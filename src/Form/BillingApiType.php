<?php

namespace App\Form;

use App\Entity\Billing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BillingApiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name')
            ->add('last_name')
            ->add('phone_number')
            ->add('email')
            ->add('paymentMethod')
            ->add('createdAt')
            ->add('totalPrice')
            ->add('billingAddress')
            ->add('billingCity')
            ->add('billingZipcode')
            ->add('deliveryMethod')
            ->add('pickupHour')
            ->add('formules')
            ->add('boissons')
            ->add('dessert')
            ->add('bagels')
            ->add('paninis')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Billing::class,
	        'csrf_protection' => false
        ]);
    }
}
