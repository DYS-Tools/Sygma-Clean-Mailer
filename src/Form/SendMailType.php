<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SendMailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Name'],
                'label' => false,
            ])
            ->add('Email', EmailType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Email'],
                'label' => false,
            ])
            ->add('Subject', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Subject'],
                'label' => false,
            ])
            ->add('Message', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Message'],
                'label' => false,

            ])

            ->add('Send', SubmitType::class, [
                'attr' => ['type'=>'submit', 'class' => 'btn btn-success button-big button-rouded', ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
