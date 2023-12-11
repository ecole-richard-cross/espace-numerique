<?php

namespace App\Form;

use App\Entity\Comment;
use App\Form\Type\TrixEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', HiddenType::class)
            ->add('editor', TrixEditorType::class, [
                'mapped' => false,
                'label' => "Répondre",
                'input_id' => 'comment_content'
            ])
            ->add('replyingTo', EntityType::class, ['class' => Comment::class, 'row_attr' => ['class' => 'd-none']])
            ->add('submit', SubmitType::class, ['label' => 'Envoyer']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
            'editorId' => 'trix_editor',
            'attr' => ['class' => 'position-relative']
        ]);
    }
}
