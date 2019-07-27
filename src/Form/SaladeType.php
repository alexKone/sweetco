<?php

namespace App\Form;

use App\Entity\Salade;
use Doctrine\DBAL\Types\ArrayType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SaladeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('base', CollectionType::class, [
            	'entry_type' => BaseType::class,
	            'entry_options' => ['label' => true]
            ])
            ->add('ingredients',CollectionType::class, [
            	'entry_type' => IngredientType::class,
	            'entry_options' => ['label' => true],
	            'allow_add' => true,
	            'allow_delete' => true
            ])
            ->add('sauce', SauceType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Salade::class,
        ]);
    }
}
