<?php

namespace App\Form;

use App\Entity\Discussion;
use App\Entity\Tag;
use App\Form\Type\TrixEditorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DiscussionType extends AbstractType
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $tags = $this->em->getRepository(Tag::class)->findAll();
        usort(
            $tags,
            function ($a, $b) {
                return \strcasecmp($a->getName(), $b->getName());
            }
        );
        $builder
            ->add('title', TextType::class, ['label' => false, 'attr' => ['placeholder' => 'Votre question']])
            ->add('tags', TagSelectType::class, [
                'data' => $tags,
                'mapped' => false,
                'allow_extra_fields' => true,
                'data_class' => null,
                'label' => false,
                'placeholder' => 'Les thèmes de votre question'
            ])
            ->add('content', HiddenType::class, ['mapped' => false])
            ->add('comments', TrixEditorType::class, [
                'label_attr' => ['class' => 'd-none'],
                'placeholder' => 'Précisez votre question ici.',
                'input_id' => 'discussion_content'
            ])
            ->add('submit', SubmitType::class, ['label' => "Envoyer"]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Discussion::class,
            'attr' => ['class' => 'container']
        ]);
    }
}
