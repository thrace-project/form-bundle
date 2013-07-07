<?php
namespace Thrace\FormBundle\Tests\DependencyInjection;

use Thrace\FormBundle\DependencyInjection\ThraceFormExtension;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class ThraceFormExtesion extends \PHPUnit_Framework_TestCase
{
    public function testRecaptcha ()
    {
        $container = new ContainerBuilder();
        $loader = new ThraceFormExtension();
        $loader->load(array(array(
            'recaptcha' => array(
                'public_key' => 'xxx',
                'private_key' => 'xxx'
            )
        )), $container);
    
        $this->assertTrue($container->hasDefinition('thrace_form.form.type.recaptcha'));
        $this->assertTrue($container->getDefinition('thrace_form.form.type.recaptcha')->hasTag('form.type'));
    }
    
    public function testTinymce ()
    {
        $container = new ContainerBuilder();
        $loader = new ThraceFormExtension();
        $loader->load(array(array(
            'tinymce' => array(
                'tiny_mce_base_path' => 'xxx',
            )
        )), $container);
    
        $this->assertTrue($container->hasDefinition('thrace_form.form.type.tinymce'));
        $this->assertTrue($container->getDefinition('thrace_form.form.type.tinymce')->hasTag('form.type'));
    }
}