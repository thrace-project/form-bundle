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

use Symfony\Component\Form\DataTransformerInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\FormView;

use Symfony\Component\OptionsResolver\Options;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\AbstractType;

/**
 * This class creates jquery select2 element
 *
 * @author Nikolay Georgiev <symfonist@gmail.com>
 * @since 1.0
 */
class Select2Type extends AbstractType
{
    /**
     * @var \Symfony\Component\Form\DataTransformerInterface
     */
    protected $transformer;
    
    /**
     * @var string
     */
    protected $widget;
    

    /**
     * Construct
     * 
     * @param DataTransformerInterface $transformer
     * @param string $widget
     */
    public function __construct(DataTransformerInterface $transformer, $widget)
    {
        $this->transformer = $transformer;
        $this->widget = $widget;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->widget === 'ajax' && $options['multiple'] === true){
            $builder->addViewTransformer($this->transformer);
        }
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
            array_search($this->getName(), $view->vars['block_prefixes']),
            0,
            'thrace_select2'
        );
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        
        $defaultConfigs = array(
            'width' => '300px',
            'allowClear' => true,  
        );
        
        $defaults = array(
            'multiple' => false,
            'expanded' => false,
            'empty_value' => 'select.empty_value',
            'translation_domain' => 'ThraceFormBundle',
            'configs' => $defaultConfigs
        );
        
        $normalizers = array(
            'expanded' => function (Options $options, $value) {
                return false;
            },           
            'configs' => function (Options $options, $value) use ($defaultConfigs) {
                $configs = array_replace_recursive($defaultConfigs, $value);
                
                $configs['placeholder'] = $options->get('empty_value');
                
                if(true === $options->get('multiple') && isset($configs['ajax'])){
                    $configs['multiple'] = true;
                }

                return $configs;
            }
        );
         
        $resolver->setDefaults($defaults);
        
        $resolver->setNormalizers($normalizers);
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::getParent()
     */
    public function getParent()
    {
        return ($this->widget === 'ajax') ? 'text' : $this->widget;
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getBlockPrefix()
    {
        return 'thrace_select2_' . $this->widget;
    }
}