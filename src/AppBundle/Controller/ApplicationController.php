<?php
/**
 * Created by PhpStorm.
 * User: boran
 * Date: 04.02.17
 * Time: 10:35
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\AppForm;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * @Route("/wecode")
 * @Security("is_granted('ROLE_USER')")
 */

class ApplicationController extends Controller
{

    /**
     * @Route("/apply",name="apply_code")
     */

    public function addAppAction(Request $request){

        $em=$this->getDoctrine()->getManager();
        $applicationObj=$em->getRepository("AppBundle:Application")->findOneBy(['User'=>$this->getUser()]);

        if($applicationObj){

            return $this->render("mainpages/success.html.twig");


        }


        $appform=$this->createForm(AppForm::class);
        $appform->handleRequest($request);
        if($appform->isValid()){

            $application=$appform->getData();

            $user=$this->getUser();
            $application->setUser($user);

            $em=$this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();

            return $this->render("mainpages/success.html.twig");
        }



        return $this->render('mainpages/app.html.twig',[
            'applicationForm'=>$appform->createView()
        ]);


    }



}