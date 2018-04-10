<?php
/**
 * Created by PhpStorm.
 * User: boran
 * Date: 21.01.17
 * Time: 19:07
 */

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @UniqueEntity(fields={"email"}, message="It looks like your already have an account!")
 */
class User implements userInterface
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */

    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */

    private $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.",checkMX = true)
     * @ORM\Column(type="string",unique=true)
     */


    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $password;


    /**
     * @Assert\Regex(
     *     pattern="((?:[a-z][a-z0-9_]*))",message="Your Password Should contains Letter (aA-zZ) and Number and Special Characters Like @/#%.."
     * )
     * @Assert\NotBlank()
     */


    private $plainPassword;

    /**
     * @ORM\Column(type="string")
     */

    private $passwordKey;

    /**
     * @ORM\Column(type="integer")
     * @Assert\EqualTo("1")
     */

    private $terms;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLoginTime;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */

    private $facebookId;

    /**
     * @ORM\Column(type="string", unique=true, nullable=true)
     */
    private $apiToken;

    /**
     * @return mixed
     */

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */

    private $twitterId;


    public function __construct()
    {
        $this->apiToken = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    /**
     * @return mixed
     */
    public function getApiToken()
    {
        return $this->apiToken;
    }


    public function getLastLoginTime()
    {
        return $this->lastLoginTime;
    }

    /**
     * @param mixed $lastLoginTime
     */
    public function setLastLoginTime(\DateTime $lastLoginTime)
    {
        $this->lastLoginTime = $lastLoginTime;
    }

    /**
     * @return mixed
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param mixed $facebookId
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
    }



    /**
     * @return mixed
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * @param mixed $terms
     */
    public function setTerms($terms)
    {
        $this->terms = $terms;
    }




    public function getPasswordKey()
    {
        return $this->passwordKey;
    }

    /**
     * @param mixed $passwordKey
     */
    public function setPasswordKey()
    {
        $this->passwordKey = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }




    public function getUsername()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }



    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }



    public function eraseCredentials()
    {
        $this->plainPassword=null;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        $this->password=null;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }


    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getTwitterId()
    {
        return $this->twitterId;
    }

    /**
     * @param mixed $twitterId
     */
    public function setTwitterId($twitterId)
    {
        $this->twitterId = $twitterId;
    }







}