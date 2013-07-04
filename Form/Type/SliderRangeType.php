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

use Symfony\Component\Form\FormView;

use Symfony\Component\OptionsResolver\Options;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\AbstractType;

/**
 * This class creates jquery slider range element
 *
 * @author Nikolay Georgiev <symfonist@gmail.com>
 * @since 1.0
 */
class SliderRangeType extends AbstractType
{

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add($options['first_name'], 'hidden')
            ->add($options['second_name'], 'hidden')
        ;   
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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $defaults = array(
            'tpl' => 'slider.value.min: __value_1__ slider.value.max: __value_2__',
            'min' => 0,
            'max' => 100,
            'orientation' => 'horizontal',
            'width' => '300px',
            'height' => '300px',
       );
    
        $resolver->setDefaults(array(
            'first_name' => 'first_slider',
            'second_name' => 'second_slider',
            'translation_domain' => 'ThraceFormBundle',
            'configs' => $defaults,
        ));
    
        $resolver->setNormalizers(array(
            'configs' => function (Options $options, $value) use ($defaults) {
                $value = array_replace_recursive($defaults, $value);
                
                if($value['orientation'] == 'horizontal'){
                    unset($value['height']);
                } else {
                    unset($value['width']);
                }
                
                $value['first_name'] = $options->get('first_name');
                $value['second_name'] = $options->get('second_name');
                $value['range'] = true;

                return $value;
            }
        ));
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'thrace_slider_range';
    }
}