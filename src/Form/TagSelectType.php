<?php

namespace App\Form;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TagSelectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tag', ChoiceType::class, [
                'placeholder' => $options['placeholder']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'label' => false,
            'placeholder' => "Tags"
        ]);
    }

    function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['placeholder'] = $options['placeholder'];
    }
}
