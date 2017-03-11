<?php
/*
 * This file is part of ThraceFormBundle
*
* (c) Nikolay Georgiev <symfonist@gmail.com>
*
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/
namespace Thrace\FormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * This class creates collection elements
 *
 * @author Nikolay Georgiev <symfonist@gmail.com>
 * @since 1.0
 */
class CollectionType extends AbstractType
{

    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\AbstractType::finishView()
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['configs'] = $options['configs'];
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function configureOptions(OptionsResolver $resolver)
    {

        $defaultConfigs = array(
            'empty_text'          => 'collection.empty',
            'empty_text_class'    => '',
            'add_button_text'     => 'button.add',
            'add_button_class'    => '',
            'remove_button_text'  => 'button.remove',
            'remove_button_class' => '',
            'fieldset_class'      => '',
        );

        $resolver->setDefaults(array(
                                   'allow_add'          => true,
                                   'allow_delete'       => true,
                                   'prototype'          => true,
                                   'by_reference'       => false,
                                   'error_bubbling'     => false,
                                   'translation_domain' => 'ThraceFormBundle',
                                   'configs'            => $defaultConfigs,
                               ));

        $resolver->setNormalizer(
            'configs', function (Options $options, $value) use ($defaultConfigs) {
            $configs = array_replace_recursive($defaultConfigs, $value);

            return $configs;
        }
        );
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::getParent()
     */
    public function getParent()
    {
        return \Symfony\Component\Form\Extension\Core\Type\CollectionType::class;
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getBlockPrefix()
    {
        return 'thrace_collection';
    }

}