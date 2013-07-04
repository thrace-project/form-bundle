<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Thrace\FormBundle\Form\Type\SliderType;

use Symfony\Component\Form\Tests\Extension\Core\Type\TypeTestCase;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

class SliderTypeTest extends TypeTestCase
{

    public function testDefaultConfigs()
    {
        $form = $this->factory->create('thrace_slider');
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(
            'tpl' => 'slider.value: __value__',
            'min' => 0,
            'max' => 100,
            'orientation' => 'horizontal',
            'width' => '300px',
            'range' => 'min',
                
        ), $configs);
    }
    
    public function testWithVerticalOrientationConfigs()
    {
        $form = $this->factory->create('thrace_slider', null, array('configs' => array('orientation' => 'vertical')));
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(
            'tpl' => 'slider.value: __value__',
            'min' => 0,
            'max' => 100,
            'orientation' => 'vertical',
            'height' => '300px',
            'range' => 'min',
                
        ), $configs);
    }
    
    public function testWithInvalidConfigs()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $form = $this->factory->create('thrace_slider', null, array('configs' => array('range' => 'invalid')));
    }
    
    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(new SliderType())
			)
    	);
    }
}