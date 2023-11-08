<?php

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('prenom2')
            ->add('prenom3')
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
            ->add('email')
            ->add('siteWeb')
            ->add('reseaux', TextareaType::class, ['mapped'=> false, 'required' => false])
            ->add('localisation', LocalisationType::class, ['mapped'=> false])
            ->add('visio')
            ->add('statut', ChoiceType::class, 
            ['choices'  => [ 'Associé' => 'Associé','Indépendant' => 'Indépendant'],
            'expanded' => true
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
