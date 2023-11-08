<?php

namespace App\Form;

use App\Entity\PassageCertification;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PassageCertificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('obtentionCertification', ChoiceType::class, 
            // ['choices'  => [ 'par admission' => 'PAR_ADMISSION','par scoring' => 'PAR_SCORING'],
            // 'expanded' => true
            // ])
            ->add('donneeCertifiee')
            ->add('dateDebutValidite', DateType::class, [
                'widget' => 'choice',
                'input'  => 'datetime_immutable',
                'format' => 'ddMMy',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                'years' => range(2000, Date('Y'))
            ])
            // ->add('dateFinValidite')
            ->add('stagiaire')
            ->add('certification');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PassageCertification::class,
        ]);
    }
}
