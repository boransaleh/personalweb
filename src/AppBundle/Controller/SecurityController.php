<?php
/**
 * Created by PhpStorm.
 * User: boran
 * Date: 21.01.17
 * Time: 20:31
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\forgetPasswordForm;
use AppBundle\Form\ResetPasswordForm;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends Controller
{

    /**
     * @Route("/login",name="login_page")
     */

    public function loginAction()
    {

        if($this->isGranted('ROLE_USER')){

            $Url = $this->generateUrl('home_page');
            return new RedirectResponse($Url);


        }


        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();///if the user enter to /login without submitt the loginform
        //this value will be null and this variable $authenticationUtils->getLastUsername() is the same variable  of
        // session variable Security::LAST_USERNAME so when the user make login the authenticator check if
        // $isLoginSubmit=$request->getPathInfo()=='/login' && $request->isMethod('POST'); and if this is true , the getcreditanal() function
        // in the LoginAuthenticator put the value of this session variable Security::LAST_USERNAME = form['_username']
        $form = $this->createForm(LoginForm::class, ['_username' => $lastUsername]);

        $forgetPasswordForm = $this->get('form.factory')->createNamed(null, forgetPasswordForm::class, null, ["method" => "POST"]);


        // last username entered by the user


        return $this->render('mainpages/Login.html.twig', array(
            'form' => $form->createView(),
            'forgetPassword' => $forgetPasswordForm->createView(),
            'error' => $error,
        ));

    }

    /**
     * @Route("/logout",name="security_logout")
     */


    public function logoutAction()
    {


        throw new\Exception('This should not be Reached');


    }

    /**
     * @Route("/forget",name="forget_password")
     */

    public function forgetPasswordAction(Request $request)
    {

        if($this->isGranted('ROLE_USER')){

            $Url = $this->generateUrl('home_page');
            return new RedirectResponse($Url);


        }


        if ($request->isXMLHttpRequest()) {

            $data = $request->getContent();
            $email = $_POST["_username"];
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository("AppBundle:User")->findOneBy(['email' => $email]);
            if (!$user) {

                return new JsonResponse(array('status' => '0', 'message' => 'HI!! this Email is not found '));
            }

            $passcode = $user->getPasswordKey();
            $message = \Swift_Message::newInstance()
                ->setSubject("Reset Password")
                ->setFrom("boran.alsaleh@gmail.com")
                ->setTo($email)
                ->setBody($this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    'Emails/ResetPassword.html.twig',
                    array('email' => $email, 'passwordKey' => $passcode)
                ),
                    'text/html');

            $this->get('mailer')->send($message);

            return new JsonResponse(array('status' => '1', 'message' => 'Thanks !! ,we sent you email to reset your password!! )'));


        }

        return new JsonResponse(array('failure' => ' Something is going wrong'), 403);


    }

    /**
     * @Route("/resetpassword/{email}/{passkey}",name="reset_password")
     */

    public function ResetAction($email, $passkey,Request $request)
    {
        if($this->isGranted('ROLE_USER')){

            $Url = $this->generateUrl('home_page');
            return new RedirectResponse($Url);


        }


        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("AppBundle:User")->findOneBy(['email' => $email]);


        if(!$user){

            throw new Exception("you are not user");
        }

        if($user->getPasswordKey()!=$passkey){

            throw new Exception("This link is not valid");


        }


        $form = $this->get('form.factory')->createNamed(null, ResetPasswordForm::class, null, ["method" => "POST"]);
        $form->handleRequest($request);
        if ($form->isSubmitted()){

            $formdata = $form->getData();

            $plainpassword=$formdata['_password'];
            $user->setPlainPassword($plainpassword);
            $user->setPasswordKey();
            $em->persist($user);
            $em->flush();
            $this->addFlash('successchangedpassword', 'Great !!! your password has been changed .. ');

        }


        return $this->render(':mainpages:ResetPasswordForm.html.twig',array('form'=>$form->createView()));




    }


}

