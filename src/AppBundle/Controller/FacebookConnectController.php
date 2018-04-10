<?php
/**
 * Created by PhpStorm.
 * User: boran
 * Date: 05.01.17
 * Time: 09:04
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Form\RegistrationForm;
use League\OAuth2\Client\Provider\FacebookUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class FacebookConnectController extends Controller
{


    /**
     * @Route("/connect/facebook", name="connect_facebook")
     */

    public  function connectFacebookAction(Request $request){


        $facebookClient = $this->get('knpu.oauth2.registry')
            ->getClient('my_facebook_client');
        return $facebookClient->redirect([
            'public_profile', 'email'
        ]);

    }


    /**
     * @Route("/connect/facebook-check", name="connect_facebook_check")
     */
    public function connectFacebookActionCheck()
    {
        // will not be reached!
    }
    /**
     * @Route("/connect/facebook/registration", name="connect_facebook_registration")
     */
    public function finishRegistration(Request $request)
    {
        /** @var FacebookUser $facebookUser */
        $facebookUser = $this->get('app.facebook_authenticator')
            ->getUserInfoFromSession($request);

        if (!$facebookUser) {
            throw $this->createNotFoundException('How did you get here without user information!?');
        }
        $user = new User();
        $user->setFacebookId($facebookUser->getId());
        $user->setEmail($facebookUser->getEmail());
        $user->setPasswordKey();
        $user->setName($facebookUser->getFirstName().' '.$facebookUser->getLastName());
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
            $request->getSession()->remove('facebook_user');
            // log the user in manually
            $guardHandler = $this->container->get('security.authentication.guard_handler');
            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $this->container->get('app.facebook_authenticator'),
                'main' // the firewall key
            );
        }
        return $this->render('mainpages/Register.html.twig', array(
            'RegisterationForm' => $form->createView()
        ));
    }
}