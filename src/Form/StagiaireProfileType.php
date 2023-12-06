<?php

namespace App\Form\Type;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StagiaireProfileType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options): void
   {
      $builder
         ->add('idDossierCpf')
         ->add('identifiantsFinanceurs')
         ->add('sexe', ChoiceType::class, ["choices" => ["M" => "M", "F" => "F"], "expanded" => true, "attr" => ["class" => "radio-2"]]);
   }

   public function configureOptions(OptionsResolver $resolver)
   {
      $resolver->setDefaults([
         'data_class' => Stagiaire::class,
      ]);
   }
}
