<?php
/**
 * Created by PhpStorm.
 * User: boran
 * Date: 18.01.17
 * Time: 20:55
 */

namespace AppBundle\Form;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class contactForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email',EmailType::class,['attr'=>['class'=>'form-control','placeholder'=>'Email']])
            ->add('subject',TextType::class,['attr'=>['class'=>'form-control','placeholder'=>'Subject']])
            ->add('message',TextareaType::class ,[
                'attr'=>['class'=>'form-control','rows'=>'5','placeholder'=>'E-mail Body'],


            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {


        ///nothing

    }

    public function getName()
  {
      return;
  }



}