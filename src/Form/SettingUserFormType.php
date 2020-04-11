<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('SMTP_host', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'SMTP HOST'],
                'label' => false,
            ])

            ->add('SMTP_password', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'SMTP PASS'],
                'label' => false,
            ])
            ->add('port', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'PORT'],
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
