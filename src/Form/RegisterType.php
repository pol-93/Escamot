<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RegisterType extends AbstractType{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    
    $builder->add('name', TextType::class, array(
                  'label' => 'Nom'
                  ))
                  ->add('nickname', TextType::class, array(
                    'label' => 'Nickname'
                  ))
                  ->add('email', EmailType::class, array(
                    'label' => 'Email'
                  ))
                  ->add('password', PasswordType::class, array(
                    'label' => 'Contrasenya'
                  ))
                  ->add('submit', SubmitType::class, array(
                    'label' => 'Registrarse'
                  ));
  }

}

?>