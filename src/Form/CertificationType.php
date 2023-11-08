<?php

namespace App\Form;

use App\Entity\Certification;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CertificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, 
            ['choices'  => [ 'RNCP' => 'RNCP','RS' => 'RS', 'Diplôme d\'Etablissement' => 'Diplôme d\'Etablissement']])
            ->add('code')
            ->add('name')
            ->add('startDate', DateType::class, [
                'widget' => 'choice',
                'input'  => 'datetime_immutable',
                'format' => 'ddMMy',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                'years' => range(2000, Date('Y')),
                'required' => false
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'choice',
                'input'  => 'datetime_immutable',
                'format' => 'ddMMy',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ],
                'years' => range(2000, Date('Y')+50),
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Certification::class,
        ]);
    }
}
