<?php

namespace App\Form\Admin;

use App\Entity\Admin\OperationData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('montant')
            ->add('annee')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Dépense' => true,
                    'Recette' => false,
                ]
            ])
            ->add('operation', null, [
                //'size' => 4,
                'empty_data' => date('Y'),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OperationData::class,
        ]);
    }
}
