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
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToArrayTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToTimestampTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ReversedTransformer;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * This class creates jquery datepicker element
 *
 * @author Nikolay Georgiev <symfonist@gmail.com>
 * @since  1.0
 */
class DatePickerType extends AbstractType
{
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $format = $options['format'];

        $builder->addViewTransformer(
            new DateTimeToStringTransformer($options['date_timezone'], $options['user_timezone'], $format)
        );

        if('string' === $options['input']) {
            $builder->addModelTransformer(
                new ReversedTransformer(
                    new DateTimeToStringTransformer($options['date_timezone'], $options['date_timezone'], $format)
                ));
        } elseif('timestamp' === $options['input']) {
            $builder->addModelTransformer(
                new ReversedTransformer(
                    new DateTimeToTimestampTransformer($options['date_timezone'], $options['date_timezone'])
                ));
        } elseif('array' === $options['input']) {
            $builder->addModelTransformer(
                new ReversedTransformer(
                    new DateTimeToArrayTransformer(
                        $options['date_timezone'], $options['date_timezone'], array(
                        'year',
                        'month',
                        'day',
                    ))
                ));
        }
    }

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

        $defaultConfigs = array(
            'showOn'          => 'button',
            'buttonImageOnly' => true,
        );

        $resolver->setDefaults(
            array(
                'input'              => 'datetime',
                'format'             => 'Y-m-d',
                'date_timezone'      => null,
                'user_timezone'      => null,
                'translation_domain' => 'ThraceFormBundle',
                'configs'            => $defaultConfigs,

            ));

        $resolver->setNormalizer(
            'configs', function (Options $options, $value) use ($defaultConfigs) {
            $configs = array_replace_recursive($defaultConfigs, $value);

            $configs['dateFormat'] = 'yy-mm-dd';

            return $configs;
        });

        $resolver->setAllowedValues(
            array(
                'input' => array(
                    'datetime',
                    'string',
                    'timestamp',
                    'array',
                ),
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
        return 'thrace_datepicker';
    }
}