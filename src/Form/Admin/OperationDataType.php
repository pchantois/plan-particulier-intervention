<?php

namespace App\Form\Admin;

use App\Entity\Admin\OperationData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('montant')
            ->add('annee')
            ->add('type')
            ->add('operation')
            ->add('OperationData', CollectionType::class, [
                'entry_type' => OperationDataForm::class,
                'allow_delete' => true,
                'allow_add' => true,
                'by_reference' => false,
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
