<?php
/**
 * Created by PhpStorm.
 * User: boran
 * Date: 07.01.17
 * Time: 00:04
 */

namespace AppBundle\Controller;

use League\OAuth1\Client\Server\Twitter;
use AppBundle\Entity\User;
use AppBundle\Form\RegistrationForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;


class TwitterAuthenticator extends Controller
{


    private $server;


    public function __construct()
    {

        if (version_compare(PHP_VERSION, '5.4.0', '<')) {
            if(session_id() == '') {

                session_start();
            }
        } else

        {
            if (session_status() == PHP_SESSION_NONE) {session_start();}
        }




    }


    /**
     * @Route("/twitter/", name="twitter_uri")
     */

    public function authenticatorAction()

    {

        $server=$this->get('oauth.twitter');


        // Start session
        $temporaryCredentials = $server->getTemporaryCredentials();
        // Store the credentials in the session.
        $_SESSION['temporary_credentials'] = serialize($temporaryCredentials);
        session_write_close();
        // Second part of OAuth 1.0 authentication is to redirect the
        // resource owner to the login screen on the server.
        $server->authorize($temporaryCredentials);

        exit();

    }

    /**
     * @Route("/twitterlogin/", name="twitter_callback_uri")
     */

    public function twitterAction(Request $request)
    {


        $server=$this->get('oauth.twitter');


        if (isset($_GET['oauth_token']) && isset($_GET['oauth_verifier']) &&  $request->getPathInfo()=="/twitterlogin/") {
            // Retrieve the temporary credentials from step 2
            $temporaryCredentials = unserialize($_SESSION['temporary_credentials']);
            // Third and final part to OAuth 1.0 authentication is to retrieve token
            // credentials (formally known as access tokens in earlier OAuth 1.0
            // specs).
            $tokenCredentials = $server->getTokenCredentials($temporaryCredentials, $_GET['oauth_token'], $_GET['oauth_verifier']);
            // Now, we'll store the token credentials and discard the temporary
            // ones - they're irrelevant at this stage.
            unset($_SESSION['temporary_credentials']);
            $_SESSION['token_credentials'] = serialize($tokenCredentials);
            session_write_close();
            // Redirect to the user page
            header("Location: http://{$_SERVER['HTTP_HOST']}/profile/?user=user");
            exit;
// Step 2.5 - denied request to authorize client
        } elseif (isset($_GET['denied'])) {
            echo 'Hey! You denied the client access to your Twitter account! If you did this by mistake, you should <a href="?go=go">try again</a>.';
// Step 2
        }

        exit();

    }

    /**
     * @Route("/profile/", name="twitter_profile")
     */

    public function loginAction(Request $request)
    {


        $server=$this->get('oauth.twitter');


        if (!isset($_SESSION['token_credentials']) ) {
            $loginUrl = $this->generateUrl('login_page');
            return new RedirectResponse($loginUrl);
        }


        $tokenCredentials = unserialize($_SESSION['token_credentials']);
        $twitterUser = $server->getUserDetails($tokenCredentials);

        $uid = $server->getUserUid($tokenCredentials);

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("AppBundle:User")->findOneBy(['twitterId' => $uid]);

        if (!$user) {

            $registrationUrl = $this->generateUrl('connect_twitter_registration');
            return new RedirectResponse($registrationUrl);

        }


        $this->addFlash('success', 'Welcome '.$user->getEmail());

        return $this->get('security.authentication.guard_handler')
            ->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $this->get('app.security.login_form_authenticator'),
                'main'
            );


    }

    /**
     * @Route("/register/", name="connect_twitter_registration")
     */

    public function twitterRegisterationAction(Request $request)
    {
        $server=$this->get('oauth.twitter');
        $tokenCredentials = unserialize($_SESSION['token_credentials']);
        $twitterUser = $server->getUserDetails($tokenCredentials);
        $uid = $server->getUserUid($tokenCredentials);

        $user = new User();
        $user->setTwitterId($uid);
        $user->setPasswordKey();
        $user->setName($server->getUserScreenName($tokenCredentials));
        $form = $this->createForm(RegistrationForm::class, $user);

        $form->handleRequest($request);
        if ($form->isValid()) {
            // encode the password manually
            $plainPassword = $form['plainPassword']->getData();
            $encodedPassword = $this->get('security.password_encoder')
                ->encodePassword($user, $plainPassword);
            $user->setPassword($encodedPassword);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            // remove the session information
            $request->getSession()->remove('token_credentials');

            $this->addFlash('success', 'Welcome '.$user->getEmail());
            // log the user in manually
            return $this->get('security.authentication.guard_handler')
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->get('app.security.login_form_authenticator'),
                    'main'

                );
        }

        return $this->render('mainpages/Register.html.twig', array(
            'RegisterationForm' => $form->createView()));


    }


}
