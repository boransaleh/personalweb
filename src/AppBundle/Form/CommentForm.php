<?php

namespace AppBundle\Form;

use AppBundle\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('email',EmailType::class,['attr'=>['class'=>'form-control','placeholder'=>'Email']])
            ->add('message',TextareaType::class ,[
                'attr'=>['class'=>'form-control','rows'=>'5','placeholder'=>'Your Comment '],

            ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {


        $resolver->setDefaults([

            'data_class'=>Comment::class
        ]);


    }


}
