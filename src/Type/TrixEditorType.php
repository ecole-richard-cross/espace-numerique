<?php

namespace App\Form\Type;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrixEditorType extends AbstractType
{

    function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'editor_id' => 'trix_editor',
            'placeholder' => 'Tapez votre message ici',
            'inherit_data' => true,
            'input_id' => 'trix-content'
        ]);
    }

    function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['editor_id'] = $options['editor_id'];
        $view->vars['placeholder'] = $options['placeholder'];
        $view->vars['input_id'] = $options['input_id'];
    }
}
