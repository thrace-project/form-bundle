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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * This class creates jquery buttonset element
 *
 * @author Nikolay Georgiev <symfonist@gmail.com>
 * @since  1.0
 */
class ButtonsetType extends AbstractType
{

    /**
     * @var string
     */
    protected $widget;

    /**
     * Construct
     *
     * @param string $widget
     */
    public function __construct($widget)
    {
        $this->widget = $widget;
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildView()
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['configs'] = $options['configs'];

        // Adds a custom block prefix
        array_splice(
            $view->vars['block_prefixes'],
            array_search($this->getBlockPrefix(), $view->vars['block_prefixes']),
            0,
            'thrace_buttonset'
        );
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'multiple'           => false,
                'translation_domain' => 'ThraceFormBundle',
                'configs'            => array(),
            ));

        $resolver->setNormalizer(
            'expanded', function (Options $options, $value) {
            return true;
        });
        $resolver->setNormalizer(
            'configs', function (Options $options, $value) {
            return $value;
        });
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::getParent()
     */
    public function getParent()
    {
        if($this->widget =='choice')
        {
            return ChoiceType::class;
        }
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getBlockPrefix()
    {
        return 'thrace_buttonset_' . $this->widget;
    }

}