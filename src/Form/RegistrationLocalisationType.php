<?php

namespace App\Form;

use App\Entity\Localisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationLocalisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codePostal', null, [
                'constraints' => [
                    new NotBlank([
                        "message" => "Veuillez renseigner votre code postal de résidence."
                    ])
                ]
            ])
            ->add('pays', null, [
                'required' => true,
                'data' => 'France',
                'row_attr' => ['class' => 'd-none mb-3'],
                'constraints' => [
                    new NotBlank([
                        "message" => "Veuillez renseigner votre pays de résidence."
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Localisation::class,
        ]);
    }
}
