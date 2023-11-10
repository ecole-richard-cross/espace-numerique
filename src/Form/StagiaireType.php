<?php

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomNaissance')
            ->add('nomUsage')
            ->add('prenom')
            ->add('dateNaissance', BirthdayType::class, [
                'widget' => 'choice',
                'input'  => 'datetime_immutable',
                'format' => 'ddMMy',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
            ])
            ->add('sexe', ChoiceType::class, 
            ['choices'  => [ 'M' => 'M','F' => 'F'],
            'expanded' => true
            ])
            ->add('codePostalNaissance')
            ->add('idDossierCpf')
            ->add('identifiantsFinanceurs')
            ->add('email')
            ->add('phone')
            ->add('visio')
            ->add('statut', ChoiceType::class, 
            ['choices'  => [ 'Associé' => 'Associé','Indépendant' => 'Indépendant'],
            'expanded' => true
            ])
            ->add('adressePostal', LocalisationType::class)
            ->add('lieuxActivite', CollectionType::class, [
                'entry_type' => LocalisationType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false,
                'prototype' => true,
                'attr' => [ 'class' => 'lieux-activite' ],
                'entry_options' => [
                    'label' => false,
                ],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}
