<?php

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StagiaireProfileType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options): void
   {
      $builder
         ->add('idDossierCpf', TextType::class, [
            'label' => 'Id Compte CPF',
            'attr' => ['placeholder' => 'Id Compte CPF'],
            'row_attr' => ['class' => 'form-floating mb-3']
        ])
         ->add('identifiantsFinanceurs', TextareaType::class, [
            'label' => 'Identifiants financeurs',
            'attr' => ['placeholder' => 'Identifiants financeurs'],
            'row_attr' => ['class' => 'form-floating mb-3']
        ]);
   }

   public function configureOptions(OptionsResolver $resolver)
   {
      $resolver->setDefaults([
         'data_class' => Stagiaire::class,
      ]);
   }
}
