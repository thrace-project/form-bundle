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

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\OptionsResolver\Options;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\AbstractType;

/**
 * This class creates jquery slider element
 *
 * @author Nikolay Georgiev <symfonist@gmail.com>
 * @since 1.0
 */
class SliderType extends AbstractType
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
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {      
        $defaultConfigs = array(
            'tpl' => 'slider.value: __value__',
            'min' => 0,
            'max' => 100,
            'orientation' => 'horizontal',
            'width' => '300px',
            'height' => '300px',
            'range' => 'min',
       );
        
        $resolver->setDefaults(array(
            'translation_domain' => 'NeutronFormBundle',
            'configs' => $defaultConfigs,
        ));
        
        $resolver->setNormalizers(array(
            'configs' => function (Options $options, $value) use ($defaultConfigs) {
                $value = array_replace_recursive($defaultConfigs, $value);
                
                if($value['orientation'] == 'horizontal'){
                    unset($value['height']);
                } else {
                    unset($value['width']);
                }
                
                if (!in_array($value['range'], array('min', 'max'), true)){
                    throw new \InvalidArgumentException(sprintf('Option range with value "%s" must be set to  "min" or "max"', $value['range']));
                }
                
                return $value;
            }
        ));
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::getParent()
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'thrace_slider';
    }
}