<?php

namespace AppBundle\Form;

use AppBundle\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('SchoolName',TextType::class,['label'=>'School Name','attr'=>['class'=>'form-control','placeholder'=>'School Name']])
            ->add('ContactPerson',TextType::class,['label'=>'Contact Person Name','attr'=>['class'=>'form-control','placeholder'=>'Contact Person Name']])
            ->add('TelfoneNumber',NumberType::class,['label'=>'Tel Number','attr'=>['class'=>'form-control','placeholder'=>'Tel Number']])
            ->add('StudentsNumber',NumberType::class,['label'=>'Number Of Students who will participate in the program ','attr'=>['class'=>'form-control','placeholder'=>'Student Number']])
            ->add('location',TextType::class,['required' => false,'label'=>false,'attr'=>['class'=>'placepicker form-control','placeholder'=>'School Address ']])
            ->add('Suggestion',TextareaType::class,['required' => false,'label'=>'Additional Note ','attr'=>['class'=>'form-control','rows'=>'5','placeholder'=>'Additional Notes ']])
            ->add('File', VichFileType::class, [
                'required' => false,
                'allow_delete' => true, // not mandatory, default is true
                'download_link' => true,
                'label'=>false,
                'attr'=>['class'=>'upload']
                // not mandatory, default is true
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([

            'data_class'=>Application::class
        ]);

    }


}
