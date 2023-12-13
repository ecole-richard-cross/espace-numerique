<?php

namespace App\Form\Type;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class AvatarType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options): void
   {
      $builder
         ->add('image', FileType::class, [
            'label' => false,
            'help'=> 'La taille maximale de l\'image est de 3MB.',
            'mapped' => false,
            'required'=> false,
            'attr' => ['accept' => 'image/*'],
            'constraints' => [
               new Image([
                  'maxSize' => '3000k',
                  'maxSizeMessage' => 'Le fichier est trop large ({{ size }} {{ suffix }}). Taille maximale {{ limit }}{{ suffix }}.',
                  'mimeTypesMessage' => 'Ce fichier n\'est pas une image.',
               ])
            ],
         ])

         ->add('type', HiddenType::class, [
            'data' => 'image',
         ])
         ->add('submit', SubmitType::class, [
            'label' => 'Confirmer'
         ]);
   }

   public function configureOptions(OptionsResolver $resolver)
   {
      $resolver->setDefaults([
         'data_class' => Media::class,
      ]);
   }
}
