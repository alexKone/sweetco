<?php

namespace App\Form;

use App\Entity\Salade;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaladeApiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createdAt')
            ->add('base')
            ->add('ingredients')
            ->add('sauce')
            ->add('formule')
            ->add('billing')
            ->add('addons')
            ->add('breads')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Salade::class,
        ]);
    }
}
