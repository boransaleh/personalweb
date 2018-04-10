<?php
/**
 * Created by PhpStorm.
 * User: boran
 * Date: 04.02.17
 * Time: 10:39
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

use AppBundle\Entity\User;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity
 * @ORM\Table(name="application")
 * @Vich\Uploadable
 */

class Application
{


    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $AppId;


    /**
     * @ORM\Column(type="string")
     */

    Private $SchoolName;


    /**
     * @ORM\Column(type="string")
     */

    Private $ContactPerson;


    /**
     * @ORM\Column(type="string")
     */

    private $TelfoneNumber;


    /**
     * @ORM\Column(type="integer")
     */

    Private $StudentsNumber;


    /**
     * @ORM\Column(type="string",nullable=true)
     */

    private $location;

    /**
     * @ORM\Column(type="text",nullable=true)
     */

    Private $Suggestion;


    /**
     * @ORM\Column(type="string",nullable=true)
     */

    Private $FileName;

    /**
     * @Vich\UploadableField(mapping="attached_File", fileNameProperty="FileName")
     */

    private $File;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */

    Private $UploadedAt;


    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     */

    Private $User;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * @param mixed $User
     */
    public function setUser(User $User)
    {
        $this->User = $User;
    }

    /**
     * @return mixed
     */
    public function getSchoolName()
    {
        return $this->SchoolName;
    }

    /**
     * @param mixed $SchoolName
     */
    public function setSchoolName($SchoolName)
    {
        $this->SchoolName = $SchoolName;
    }

    /**
     * @return mixed
     */
    public function getContactPerson()
    {
        return $this->ContactPerson;
    }

    /**
     * @param mixed $ContactPerson
     */
    public function setContactPerson($ContactPerson)
    {
        $this->ContactPerson = $ContactPerson;
    }

    /**
     * @return mixed
     */
    public function getTelfoneNumber()
    {
        return $this->TelfoneNumber;
    }

    /**
     * @param mixed $TelfoneNumber
     */
    public function setTelfoneNumber($TelfoneNumber)
    {
        $this->TelfoneNumber = $TelfoneNumber;
    }

    /**
     * @return mixed
     */
    public function getStudentsNumber()
    {
        return $this->StudentsNumber;
    }

    /**
     * @param mixed $StudentsNumber
     */
    public function setStudentsNumber($StudentsNumber)
    {
        $this->StudentsNumber = $StudentsNumber;
    }

    /**
     * @return mixed
     */
    public function getSuggestion()
    {
        return $this->Suggestion;
    }

    /**
     * @param mixed $Suggestion
     */
    public function setSuggestion($Suggestion)
    {
        $this->Suggestion = $Suggestion;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }


    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->File;
    }

    /**
     * @param mixed $File
     */
    public function setFile(File $File=null)
    {
        $this->File = $File;

        if ($File) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->UploadedAt = new \DateTimeImmutable();
        }
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->FileName;
    }

    /**
     * @param mixed $FileName
     */
    public function setFileName($FileName)
    {
        $this->FileName = $FileName;
    }

    /**
     * @return mixed
     */
    public function getUploadedAt()
    {
        return $this->UploadedAt;
    }

    /**
     * @param mixed $UploadedAt
     */
    public function setUploadedAt($UploadedAt)
    {
        $this->UploadedAt = $UploadedAt;
    }


}