<?php
/**
 * Created by PhpStorm.
 * User: boran
 * Date: 17.01.17
 * Time: 22:01
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Form\CommentForm;
use AppBundle\Form\contactForm;
use AppBundle\Form\RegistrationForm;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MainController extends Controller
{

    /**
     * @Route("/",name="home_page")
     */


    public function homeAction(Request $request)
    {


        $form = $this->get('form.factory')->createNamed(null, contactForm::class);


        return $this->render("mainpages/homepage.html.twig", ['ContactForm' => $form->createView()]);


    }



    /**
     * @Route("/registeration",name="register_page")
     */

    public function registerAction(Request $request)
    {
        if($this->isGranted('ROLE_USER')){

            $Url = $this->generateUrl('home_page');
            return new RedirectResponse($Url);


        }

        $form=$this->createForm(RegistrationForm::class);

        $form->handleRequest($request);
        if($form->isValid()){

            $user=$form->getData();
            $user->setPasswordKey();
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success','welcome'.$user->getEmail());
            $message = \Swift_Message::newInstance()
                ->setSubject('Registeration is Done ')
                ->setFrom('boran.alsaleh@gmail.com')
                ->setTo($user->getEmail())
                ->setBody("Thanks for Your Registeration , in case you have any Question , do not hesitate to contact me ");

            $this->get('mailer')->send($message);
            return $this->get('security.authentication.guard_handler')
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->get('app.security.login_form_authenticator'),
                    'main'
                );
        }
        return $this->render("mainpages/Register.html.twig",array(
            "RegisterationForm"=>$form->createView(),
        ));

    }

    /**
     * @Route("/success",name="success_page")
     */

    public function successAction(Request $request)
    {

        if ($request->isXMLHttpRequest()) {

            $data = $request->getContent();
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];

            $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($email)
                ->setTo('boran.alsaleh@gmail.com')
                ->setBody($message . $email);

            $this->get('mailer')->send($message);

            return new JsonResponse(array('success' => 'Thanks !! , I will reply to your Email ASAP :)'));


        }

        return new JsonResponse(array('failed' => ' Something is going wrong'));


    }

    /**
     * @Route("/wecode",name="we_code")
     * @Method("GET")
     */


    public function wecodeAction(){

        $commentForm=$form = $this->get('form.factory')->createNamed(null, CommentForm::class);

        return $this->render(":mainpages:WeCodeKids.html.twig",[
            'CommentForm'=>$commentForm->createView(),
        ]);



    }

    /**
     * @Route("/savecomment",name="save_comment")
     */

    public function postComment(Request $request){


        if ($request->isXMLHttpRequest()) {


            $data=$request->getContent();
            $email = $_POST['email'];
            $msg=$_POST['message'];

            $CommentObj=new Comment();

            $CommentObj->setCommentText($msg);
            $CommentObj->setEmail($email);
            $CommentObj->setCommentDate(new \DateTime());
            $em=$this->getDoctrine()->getManager();
            $em->persist($CommentObj);
            $em->flush();


            return new JsonResponse(array('status' => '1', 'message' => 'Thanks!!! '));


        }

        return new JsonResponse(array('failed' => 'Something is going wrong'));


    }

    /**
     * @Route("/getcomments",name="get_comments")
     */

    public function getComment(){


            $comments=[];
            $em=$this->getDoctrine()->getManager();
            $allcomment=$em->getRepository(Comment::class)->findAll();
            foreach($allcomment as $commentObj){

                $date=$commentObj->getCommentDate();
                $datetime=$date->format('Y-m-d H:i:s');




                $comments[]=[
                    'id'=>$commentObj->getId(),
                    'email'=>$commentObj->getEmail(),
                    'comment'=>$commentObj->getCommentText(),
                    'date'=>$datetime
                ];
            }





            return new JsonResponse($comments);




    }









}