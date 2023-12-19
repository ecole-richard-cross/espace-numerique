<?php

namespace App\Form;

use App\Entity\PresenceWeb;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class presenceWebType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options): void
   {
      $builder
         ->add('type', ChoiceType::class, [
            'choices' => ["Réseau social" => "Réseau social", "Site web" => "Site web"],
            'label' => 'Type',
            'attr' => ['placeholder' => 'Type'],
            'row_attr' => ['class' => 'form-floating']
        ])
         ->add('url', UrlType::class, [
            'label' => 'Url',
            'attr' => ['placeholder' => 'Url'],
            'row_attr' => ['class' => 'form-floating']
        ])
         ;
   }

   public function configureOptions(OptionsResolver $resolver)
   {
      $resolver->setDefaults([
         'data_class' => PresenceWeb::class,
      ]);
   }
}