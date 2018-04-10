<?php
/**
 * Created by PhpStorm.
 * User: boran
 * Date: 21.01.17
 * Time: 23:05
 */

namespace AppBundle\Security;

use AppBundle\Form\LoginForm;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{


    /**
     * LoginFormAuthenticator constructor.
     */

    private $formFactory;
    private $em;
    private $router;
    private $passwordEncoder;
    public function __construct(FormFactoryInterface $formfactory,EntityManager $em,RouterInterface $router,UserPasswordEncoder $passwordEncoder)
    {
        $this->formFactory=$formfactory;
        $this->em=$em;
        $this->router=$router;
        $this->passwordEncoder=$passwordEncoder;
    }

    public function getCredentials(Request $request)
    {
        $isLoginSubmit=$request->getPathInfo()=='/login' && $request->isMethod('POST');

        if(!$isLoginSubmit){

            return ;
        }

        $form=$this->formFactory->create(LoginForm::class);
        $form->handleRequest($request);

        $data=$form->getData();

        $request->getSession()->set(Security::LAST_USERNAME,$data['_username']);


        return $data;


    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username=$credentials['_username'];
        return $this->em->getRepository('AppBundle:User')->findOneBy(['email'=>$username]);

    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $password=$credentials['_password'];
        if($this->passwordEncoder->isPasswordValid($user,$password)){

            return true;
        }
        return false;
    }

    protected function getLoginUrl()
    {
       return $this->router->generate('login_page');
    }

    protected function getDefaultSuccessRedirectUrl()
    {


       return $this->router->generate('apply_code');


    }



}