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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * This class creates jquery spinner widget
 *
 * @author Nikolay Georgiev <symfonist@gmail.com>
 * @since  1.0
 */
class SpinnerType extends AbstractType
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
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $defaultConfigs = array();

        $resolver->setDefaults(
            array(
                'translation_domain' => 'ThraceFormBundle',
                'configs'            => $defaultConfigs,
            ));

        $resolver->setNormalizers(
            array(
                'configs' => function (Options $options, $value) use ($defaultConfigs) {
                    $configs = array_replace_recursive($defaultConfigs, $value);

                    return $configs;
                },
            ));
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::getParent()
     */
    public function getParent()
    {
        return TextType::class;
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getBlockPrefix()
    {
        return 'thrace_spinner';
    }
}