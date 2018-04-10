<?php
/**
 * Created by PhpStorm.
 * User: boran
 * Date: 01.02.17
 * Time: 20:39
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="Comment")
 */
class Comment
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */

    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     */
    private $commentText;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */

    private $CommentDate;

    /**
     * @return mixed
     */
    public function getCommentDate()
    {
        return $this->CommentDate;
    }

    /**
     * @param mixed $CommentDate
     */
    public function setCommentDate(\DateTime $CommentDate)
    {
        $this->CommentDate = $CommentDate;
    }






    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getCommentText()
    {
        return $this->commentText;
    }

    /**
     * @param mixed $commentText
     */
    public function setCommentText($commentText)
    {
        $this->commentText = $commentText;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }





}