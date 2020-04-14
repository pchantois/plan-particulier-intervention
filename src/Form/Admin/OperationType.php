<?php

namespace App\Form\Admin;

use App\Entity\Admin\Operation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('libelle')
            ->add('description', null, [
                'attr' => [
                    'rows' => 7,
                ]
            ])
            ->add('commentaire', null, [
                'attr' => [
                    'rows' => 7,
                ]
            ])
            ->add('regroupementOpe')
            ->add('codeMaire')
            ->add('natureOpe')
            ->add('politiquePub')
            ->add('dob')
            ->add('recueil')
            ->add('operationData')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}
