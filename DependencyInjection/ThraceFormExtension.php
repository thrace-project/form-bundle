<?php

namespace Thrace\FormBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\DefinitionDecorator;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ThraceFormExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        
        if (isset($config['recaptcha'])){
            $container
                ->getDefinition('thrace_form.form.type.recaptcha')
                ->addArgument($config['recaptcha'])
                ->addTag('form.type', array('alias' => 'thrace_recaptcha'))
            ;
        
            $container
                ->getDefinition('thrace_form.validator.constraint.recaptcha')
                ->addArgument($config['recaptcha'])
                ->addTag('validator.constraint_validator', array('alias' => 'thrace_form_recaptcha_validator'))
            ;
        }
        
        if (isset($config['tinymce'])){ 
            $container
                ->getDefinition('thrace_form.form.type.tinymce')
                ->addArgument($config['tinymce'])
                ->addTag('form.type', array('alias' => 'thrace_tinymce'))
            ;
        } 
        
        $this->loadExtendedTypes('thrace_form.form.type.buttonset', 'thrace_buttonset', $container);
        $this->loadExtendedTypes('thrace_form.form.type.select2', 'thrace_select2', $container);
        
        $container->setParameter('thrace_form.datagrid_exists', class_exists('Thrace\DataGridBundle\ThraceDatagridBundle'));
    }
    
    /**
     * Loads extended form types.
     *
     * @param string           $serviceId Id of the abstract service
     * @param string           $name      Name of the type
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    private function loadExtendedTypes($serviceId, $name, ContainerBuilder $container)
    {
        foreach (array('choice', 'language', 'country', 'timezone', 'locale', 'entity', 'ajax') as $type) {
            $typeDef = new DefinitionDecorator($serviceId);
            $typeDef
                ->addArgument($type)
                ->addTag('form.type', array('alias' => $name. '_' . $type))
            ;
    
            $container->setDefinition($serviceId.'.'.$type, $typeDef);
        }
    }
}
