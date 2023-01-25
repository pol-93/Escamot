<?php
namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BlogtemplateType extends AbstractType{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('title', TextType::class, array(
      'label' => 'títol'
    ))    
    ->add('templatetype', ChoiceType::class, [
        'choices'  => [
            'Escolleix una opció' => "",
            'Plantilla 1' => "Plantilla1",
            'Plantilla 2' => "Plantilla2",
        ],
        'choice_attr' => [
          'Escolleix una opció' => ['disabled' => 'disabled'],
        ],
        'label' => 'seleccionar plantilla'
    ])
    ->add('submit', SubmitType::class, array(
      'label' => 'Seguent'
    ));
  }
}
?>