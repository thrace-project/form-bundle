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

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormView;

use Symfony\Component\OptionsResolver\Options;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToArrayTransformer;

use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToTimestampTransformer;

use Symfony\Component\Form\ReversedTransformer;

use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\AbstractType;

/**
 * This class creates jquery datetimepicker element
 *
 * @author Nikolay Georgiev <symfonist@gmail.com>
 * @since 1.0
 */
class DateTimePickerType extends AbstractType
{

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->addViewTransformer(
            new DateTimeToStringTransformer($options['date_timezone'], $options['user_timezone'], $options['datetime_format'])
        );

        if ('string' === $options['input']) {
            $builder->addModelTransformer(new ReversedTransformer(
                new DateTimeToStringTransformer($options['date_timezone'], $options['date_timezone'], $options['datetime_format'])
            ));
        } elseif ('timestamp' === $options['input']) {
            $builder->addModelTransformer(new ReversedTransformer(
                new DateTimeToTimestampTransformer($options['date_timezone'], $options['date_timezone'])
            ));
        } elseif ('array' === $options['input']) {
            $builder->addModelTransformer(new ReversedTransformer(
                new DateTimeToArrayTransformer($options['date_timezone'], $options['date_timezone'], $options['parts'])
            ));
        }
    }

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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
    
        $defaultConfigs = array(
            'showOn'     => 'button',
            'buttonImageOnly' => true,
            'dateFormat' => 'yy-mm-dd',
            'timeFormat' => 'HH:mm',
            'showSecond' => false,
        );
    
        $resolver->setDefaults(array(
            'input' => 'datetime',
            'with_seconds' => false,
            'use_meridiem' => false,
            'date_timezone' => null,
            'user_timezone' => null,
            'datetime_format' => 'Y-m-d H:i',
            'parts' => array('year', 'month', 'day', 'hour', 'minute'),
            'translation_domain' => 'ThraceFormBundle',
            'configs' => $defaultConfigs
        ));
    
        $resolver->setNormalizers(array(
            'datetime_format' => function (Options $options, $value) {
                if ($options->has('with_seconds') && $options->get('with_seconds') === true){
                    return ($options->get('use_meridiem') === true) ? 'Y-m-d h:i:s a' : 'Y-m-d H:i:s';
                }
                
                return ($options->get('use_meridiem') === true) ? 'Y-m-d h:i a' : 'Y-m-d H:i';
                
            },
            'parts' => function (Options $options, $value){
                if ($options->has('with_seconds') && $options->get('with_seconds') === true){
                    return  array('year', 'month', 'day', 'hour', 'minute', 'second');
                } 
                
                return array('year', 'month', 'day', 'hour', 'minute');
                
            },
            'configs' => function (Options $options, $value) use ($defaultConfigs) {
                $configs = array_replace_recursive($defaultConfigs, $value);

                if (!$options->has('with_seconds') || $options->get('with_seconds') === false){
                    $configs['timeFormat'] =  ($options->get('use_meridiem') === true) ? 'hh:mm tt' : 'HH:mm';
                    $configs['showSecond'] = false;
                } else {
                    $configs['timeFormat'] =  ($options->get('use_meridiem') === true) ? 'hh:mm:ss tt' : 'HH:mm:ss';
                    $configs['showSecond'] = true;
                }

                return $configs;
            }
        ));
    
        $resolver->setAllowedValues(array(
            'input' => array(
                'datetime',
                'string',
                'timestamp',
                'array',
            ),
            'datetime_format' => array(
                'Y-m-d H:i:s',
                'Y-m-d h:i:s a',
                'Y-m-d H:i',
                'Y-m-d h:i a'
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
        return 'thrace_datetimepicker';
    }
}