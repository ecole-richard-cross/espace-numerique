<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options): void
   {
      $builder
         ->add('nomNaissance', TextType::class, [
            'label' => 'Nom de naissance',
            'attr' => ['placeholder' => 'Nom de naissance'],
            'row_attr' => ['class' => 'form-floating']
        ])
         ->add('nomUsage', TextType::class, [
            'label' => 'Nom d\'usage',
            'attr' => ['placeholder' => 'Nom d\'usage'],
            'row_attr' => ['class' => 'form-floating']
        ])
         ->add('prenom', TextType::class, [
            'label' => 'Prénom',
            'attr' => ['placeholder' => 'Prénom'],
            'row_attr' => ['class' => 'form-floating']
        ])
         ->add('dateNaissance', BirthdayType::class, [
            'label' => 'Date de naissance',
            'input'  => 'datetime_immutable'
         ])
         ->add('adressePostale', LocalisationType::class, [
            'error_bubbling' => false
         ])
         ->add('phoneNumber', TextType::class, [
            'label' => 'Téléphone',
            'attr' => ['placeholder' => 'Téléphone'],
            'row_attr' => ['class' => 'form-floating mb-3']
        ])
         ->add('nomStructure', TextType::class, [
            'label' => 'Nom de l\'entreprise',
            'attr' => ['placeholder' => 'Nom de l\'entreprise'],
            'row_attr' => ['class' => 'form-floating mb-3']
        ])
         ->add('lieuxActivite', CollectionType::class, [
            'label' => 'Lieux d\'activité',
            'entry_type' => LocalisationType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'error_bubbling' => false
         ])
         ->add('presenceWebs', CollectionType::class, [
            'label' => 'Réseaux et sites',
            'entry_type' => presenceWebType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
         ]);

      if (in_array("ROLE_STAGIAIRE", $options['user']->getRoles()) || in_array("ROLE_EX_STAGIAIRE", $options['user']->getRoles())) {
         $builder
            ->add('stagiaire', StagiaireProfileType::class);
      }

      $builder->add('submit', SubmitType::class);
   }

   public function configureOptions(OptionsResolver $resolver)
   {
      $resolver->setDefaults([
         'data_class' => User::class,
         'user' => null,
      ]);
   }
}
