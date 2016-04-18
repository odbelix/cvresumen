<?php
// src/AppBundle/Form/RegistrationType.php

namespace Daem\Bundle\CvBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationFormPostulant extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname',null,array(
          'attr' => array(
            'class' => 'form-control',
            'placeholder' => 'Primer Nombre'
          ),
          'label' => 'Primer nombre')
        );

        /* FIELDS FOR Authentication*/
        $builder->add('username',null,array(
          'attr' => array(
            'class' => 'form-control',
            'placeholder' => 'Nombre de Usuario'
          ),
          'label' => 'Nombre de Usuario')
        );




          $builder->add('firstname',null,array(
          'attr' => array(
            'class' => 'form-control',
            'placeholder' => 'Primer Nombre'
          ),
          'label' => 'Primer nombre')
        );

        $builder->add('middlename',null,array(
          'attr' => array(
            'class' => 'form-control',
            'placeholder' => 'Segundo Nombre'
          ),
          'label' => 'Segudo nombre')
        );
        $builder->add('lastname',null,array(
          'attr' => array(
            'class' => 'form-control',
            'placeholder' => 'Apellido Paterno'
          ),
          'label' => 'Apellido Paterno')
        );

        $builder->add('momlastname',null,array(
          'attr' => array(
            'class' => 'form-control',
            'placeholder' => 'Apellido Materno'
          ),
          'label' => 'Apellido Materno')
        );

        $builder->add('gender', ChoiceType::class, array(
          'attr' => array(
            'class' => 'form-control',
          ),
          'choices'  => array('Femenino' => 'Femenino', 'Masculino' => 'Masculino'),
          'label' => 'Selecciona tu género',
          'placeholder' => "Selecciona tu género"
        ));
        //$builder->add('birthdate',null,array('label' => 'Fecha de Nacimiento'));

        $builder->add('birthdate', BirthdayType::class, array(
        'attr' => array(
          'class' => 'form-control text-center',
        ),
        'placeholder' => array(
        'day' => 'Dia', 'month' => 'Mes', 'year' => 'Año',
        ),
        'format' => 'dd-MM-yyyy',
        'label' => 'Fecha de Nacimiento',
        ));

        $builder->add('phone',null,array(
          'attr' => array(
            'class' => 'form-control',
            'placeholder' => 'Telefono fijo'
          ),
          'label' => 'Telefono fijo')
        );

        $builder->add('celphone',null,array(
          'attr' => array(
            'class' => 'form-control',
            'placeholder' => 'Celular'
          ),
          'label' => 'Celular')
        );

        $builder->add('address',null,array(
          'attr' => array(
            'class' => 'form-control',
            'placeholder' => 'Direccion'
          ),
          'label' => 'Direccion')
        );

        $builder->add('city',null,array(
          'attr' => array(
            'class' => 'form-control',
            'placeholder' => 'Ciudad'
          ),
          'label' => 'Ciudad')
        );
    }


    public function getParent() {
      return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }
    public function getBlockPrefix() {
      return 'app_user_registration';
    }
    // Not necessary on Symfony 3+
    public function getName() {
      return 'app_user_registration';
    }
}
