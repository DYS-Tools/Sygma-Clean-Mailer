<?php

namespace App\Form;


use App\Entity\ListMail;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CleanOptionsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('listSelect', EntityType::class, [
                'class' => ListMail::class,
                'help' => 'select Mailing List',
                'placeholder' => 'Select List',
                'required'   => true,
                'choice_label' => function(ListMail $list) {
                    return ''.$list->getName().' ( '.$list->getContact().' Contact )';
                },
            ])

            ->add('severe', CheckboxType::class, [
                'label' => 'Severe Mode',
                'required'   => false,
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
