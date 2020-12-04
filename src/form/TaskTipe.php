<?php 
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class TaskType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('title', TextType::class, [
            'label' => 'Titulo',
            'attr' => ['class' => 'form-control']
        ])
        ->add('content', TextareaType::class, [
            'label' => 'Descripcion',
            'attr' => ['class' => 'form-control']
        ])
        ->add('priority', ChoiceType::class, [
            'label' => 'Prioridad',
            'choices' => array(
                'Alta' => 'Alta',
                'Media' => 'Media',
                'Baja' => 'Baja'
            ),
            'attr' => ['class' => 'form-control']
        ])
        ->add('hours', TextType::class, [
            'label' => 'Horas presupuestadas',
            'attr' => ['class' => 'form-control']
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Crear Tarea',
            'attr' => ['class' => 'btn btn-primary']
        ])
      ;
    }
}