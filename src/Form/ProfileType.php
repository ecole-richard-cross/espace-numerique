<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options): void
   {
      $builder
         ->add('nomNaissance')
         ->add('nomUsage')
         ->add('prenom')
         ->add('dateNaissance', BirthdayType::class)
         ->add('adressePostale', LocalisationType::class)
         ->add('phoneNumber')
         ->add('email')
         ->add('nomStructure')
         ->add('presenceWebs', CollectionType::class, [
            'entry_type' => presenceWebType::class
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
