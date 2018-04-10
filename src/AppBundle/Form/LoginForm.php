<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('_username',EmailType::class,['attr'=>['class'=>'form-control','placeholder'=>'Email']])
            ->add('_password',PasswordType::class,['attr'=>['class'=>'form-control','placeholder'=>'Password']]);

    }


}
