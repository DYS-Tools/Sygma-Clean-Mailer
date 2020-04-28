<?php

namespace App\Form\searchMail;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KeywordSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('keyword', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Keyword'],
                'label' => false,
            ])

            ->add('Google', CheckboxType::class, [
                'label' => 'Google',
                'required'   => false,
                'by_reference' => false,
            ])

            ->add('Facebook', CheckboxType::class, [
                'label' => 'Facebook',
                'required'   => false,
                'by_reference' => false,
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
