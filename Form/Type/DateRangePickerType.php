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

use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\FormView;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\OptionsResolver\Options;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;

/**
 * This class creates jquery date range picker element
 *
 * @author Nikolay Georgiev <symfonist@gmail.com>
 * @since 1.0
 */
class DateRangePickerType extends AbstractType
{

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add($options['first_name'], DatePickerType::class, array_merge($options['options'], $options['first_options']))
            ->add($options['second_name'], DatePickerType::class, array_merge($options['options'], $options['second_options']))
        ;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildView()
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['configs'] = array(
            'first_name' => $options['first_name'], 
            'second_name' => $options['second_name'],
        );
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(array(
            'options' => array(),
            'first_options'  => array(),
            'second_options' => array(),
            'first_name'     => 'first_date',
            'second_name'    => 'second_date',
            'error_bubbling' => false,
            'translation_domain' => 'ThraceFormBundle',
        ));
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getBlockPrefix()
    {
        return 'thrace_daterangepicker';
    }
}