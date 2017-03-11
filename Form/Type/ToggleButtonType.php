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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * This class creates jquery toggle button element
 *
 * @author Nikolay Georgiev <symfonist@gmail.com>
 * @since  1.0
 */
class ToggleButtonType extends AbstractType
{

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildView()
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['configs'] = $options['configs'];
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $defaultConfigs = array(
            'checked_label'   => 'label.checked',
            'unchecked_label' => 'label.unchecked',
        );

        $resolver->setDefaults(
            array(
                'translation_domain' => 'ThraceFormBundle',
                'configs'            => $defaultConfigs,
            ));

        $resolver->setNormalizers(
            array(
                'configs' => function (Options $options, $value) use ($defaultConfigs) {
                    return array_replace_recursive($defaultConfigs, $value);
                },
            ));

        $resolver->setNormalizer(
            'configs', function (Options $options, $value) use ($defaultConfigs) {
            return array_replace_recursive($defaultConfigs, $value);

        });
    }


    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::getParent()
     */
    public function getParent()
    {
        return CheckboxType::class;
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getBlockPrefix()
    {
        return 'thrace_toggle_button';
    }
}