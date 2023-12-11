<?php

namespace App\Form\Type;

use App\Entity\Localisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocalisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'attr' => ['placeholder' => 'Adresse'],
                'row_attr' => ['class' => 'form-floating'],
                'required' => false
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code postal',
                'attr' => ['placeholder' => 'Code postal'],
                'row_attr' => ['class' => 'form-floating']
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'attr' => ['placeholder' => 'Ville'],
                'row_attr' => ['class' => 'form-floating']
            ])
            ->add('pays', TextType::class, [
                'label' => 'Pays',
                'attr' => ['placeholder' => 'Pays'],
                'row_attr' => ['class' => 'form-floating']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Localisation::class,
        ]);
    }
}
