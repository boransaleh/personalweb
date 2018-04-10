<?php
/**
 * Created by PhpStorm.
 * User: boran
 * Date: 10.04.18
 * Time: 21:16
 */

namespace AppBundle\Listener;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;

class LogoutListener implements LogoutHandlerInterface
{
    protected $em;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em=$entityManager;
    }

    /**
     * This method is called by the LogoutListener when a user has requested
     * to be logged out. Usually, you would unset session variables, or remove
     * cookies, etc.
     *
     * @param Request $request
     * @param Response $response
     * @param TokenInterface $token
     */
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
        $user = $token->getUser();
        $myfile = fopen("logout.txt", "w");
        fwrite($myfile, $user->getName());
        fclose($myfile);
    }
}