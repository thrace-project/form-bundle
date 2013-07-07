<?php
/*
 * This file is part of ThraceFormBundle
*
* (c) Nikolay Georgiev <symfonist@gmail.com>
*
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/
namespace Thrace\FormBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('thrace_form');
    
        $this->addRecaptchaConfiguration($rootNode);
        $this->addTinyMCEConfiguration($rootNode);
        
        return $treeBuilder;
    }
    
    /**
     * Recaptcha configurations
     *
     * @param ArrayNodeDefinition $rootNode
     * @return void
     */
    private function addRecaptchaConfiguration(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('recaptcha')
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('public_key')->isRequired()->end()
                        ->scalarNode('private_key')->isRequired()->end()
                        ->scalarNode('verify_url')->defaultValue('http://www.google.com/recaptcha/api/verify')->end()
                        ->scalarNode('server_url')->defaultValue('https://api-secure.recaptcha.net')->end()
                        ->scalarNode('theme')->defaultValue('red')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
    
    
    /**
     * Tinymce configurations
     * 
     * @param ArrayNodeDefinition $rootNode
     * @return void
     */
    private function addTinyMCEConfiguration(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('tinymce')
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('tiny_mce_base_path')
                            ->isRequired(true)
                            ->beforeNormalization()
                                ->always()
                                ->then(function($v) {
                                    return trim($v, '/');
                                })
                            ->end()
                        ->end()
                        ->scalarNode('theme')
                            ->defaultValue('modern')
                            ->validate()
                                ->ifNotInArray(array('modern'))
                                ->thenInvalid('The theme %s is not supported. Please choose one of '.json_encode(array('modern')))
                            ->end()
                        ->end()
                        ->scalarNode('skin')
                            ->defaultValue('lightgray')
                            ->validate()
                                ->ifNotInArray(array('lightgray'))
                                ->thenInvalid('The skin %s is not supported. Please choose one of '.json_encode(array('lightgray')))
                            ->end()
                        ->end()
                        ->scalarNode('width')->defaultValue('100%')->end()
                        ->scalarNode('height')->defaultValue(300)->end()
                        ->scalarNode('content_css')->defaultNull()->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
