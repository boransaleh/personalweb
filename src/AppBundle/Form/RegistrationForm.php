<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Entity\User;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add("name",TextType::class,['label'=>'Your Name','attr'=>['class'=>'form-control','placeholder'=>'Your Name']])
            ->add("email",EmailType::class,['label'=>'Your Email','attr'=>['class'=>'form-control','placeholder'=>'Email']])
            ->add("plainPassword",RepeatedType::class,[
                "type"=>PasswordType::class
            ])->add("terms",CheckboxType::class,['label'=>'You must read and agree to our terms and conditions','label_attr'=>['class'=>'form-check-label'],'attr'=>['class'=>'form-check-input']]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults([

            'data_class'=>User::class
        ]);
    }
}
