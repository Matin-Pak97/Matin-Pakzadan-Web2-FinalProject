<?php

namespace App\Form;

use App\Entity\RatePlan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RatePlanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('price')
            ->add('isDefault')
            ->add('extraGuestPrice')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('property')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RatePlan::class,
        ]);
    }
}
