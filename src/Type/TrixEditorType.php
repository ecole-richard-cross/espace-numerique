<?php

namespace App\Form\Type;

use App\Entity\Comment;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TrixEditorType extends AbstractType
{

    function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'editorId' => 'trix_editor',
            'placeholder' => 'Tapez votre message ici',
            'inherit_data' => true
        ]);
    }

    function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['editorId'] = $options['editorId'];
        $view->vars['placeholder'] = $options['placeholder'];
    }
}
