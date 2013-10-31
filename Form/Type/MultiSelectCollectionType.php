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

use Thrace\DataGridBundle\DataGrid\DataGridInterface;

use Symfony\Component\Form\FormView;

use Symfony\Component\OptionsResolver\Options;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\AbstractType;

/**
 * This class creates jquery multi select element
 *
 * @author Nikolay Georgiev <symfonist@gmail.com>
 * @since 1.0
 */
class MultiSelectCollectionType extends AbstractType
{

    /**
     * @var boolean
     */
    protected $datagridExists;
    
    /**
     * Construct
     * 
     * @param boolean $datagridExists
     */
    public function __construct($datagridExists)
    {
        $this->datagridExists = (bool) $datagridExists;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildView()
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        
        if (!$options['grid'] instanceof DataGridInterface){
            throw new \InvalidArgumentException('Option grid must be instance of DataGridInterface.');
        } elseif ($options['grid']->isMultiSelectEnabled() !== true){
            throw new \InvalidArgumentException('DataGridInterface::enableMultiSelect must be set to true');
        }
  
        $view->vars['grid'] = $options['grid'];
        $view->vars['configs'] = $options['configs'];
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $defaultConfigs = array(
            'datagrid_exists' => $this->datagridExists,   
        );
        
        $resolver->setDefaults(array(
            'allow_add' => true,
            'allow_delete' => true,
            'prototype' => true,
            'by_reference' => false,
            'type' => 'thrace_multi_select',
            'translation_domain' => 'ThraceFormBundle',
            'configs' => $defaultConfigs,
        ));
        
        $resolver->setNormalizers(array(            
            'configs' => function (Options $options, $value) use ($defaultConfigs){
                $configs = array_replace_recursive($defaultConfigs, $value);
                return $configs;
            }
        ));
          
        $resolver->setRequired(array('grid'));
        
        $resolver->setAllowedTypes(array(
            'grid' => array('object'),
        ));
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::getParent()
     */
    public function getParent()
    {
        return 'collection';
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'thrace_multi_select_collection';
    }
}