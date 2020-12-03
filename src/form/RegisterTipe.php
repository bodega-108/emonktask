<?php 
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class RegisterType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('name', TextType::class, [
            'label' => 'Nombre',
            'attr' => ['class' => 'form-control']
        ])
        ->add('surname', TextType::class, [
            'label' => 'Apellidos',
            'attr' => ['class' => 'form-control']
        ])
        ->add('email', EmailType::class, [
            'label' => 'Email',
            'attr' => ['class' => 'form-control']
        ])
        ->add('password', PasswordType::class, [
            'label' => 'Contraseña',
            'attr' => ['class' => 'form-control']
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Registrarce',
            'attr' => ['class' => 'btn btn-primary']
        ]);
    }
}