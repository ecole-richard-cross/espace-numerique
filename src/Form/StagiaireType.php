<?php

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
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
            ->add('dateNaissance')
            ->add('sexe')
            ->add('codePostalNaissance')
            ->add('idDossierCpf')
            ->add('email')
            ->add('siteWeb')
            // ->add('reseaux', '', ['mapped'=> false])
            ->add('localisation', LocalisationType::class, ['mapped'=> false])
            ->add('visio')
            ->add('statut')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}
