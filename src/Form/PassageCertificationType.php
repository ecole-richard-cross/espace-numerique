<?php

namespace App\Form;

use App\Entity\PassageCertification;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PassageCertificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('obtentionCertification')
            ->add('donneeCertifiee')
            ->add('dateDebutValidite')
            ->add('dateFinValidite')
            ->add('presenceNiveauLangueEuro')
            ->add('presenceNiveauNumeriqueEuro')
            ->add('scoring')
            ->add('mentionValidee')
            ->add('stagiaireId')
            ->add('certificationId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PassageCertification::class,
        ]);
    }
}
