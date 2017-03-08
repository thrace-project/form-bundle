<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Thrace\FormBundle\Form\Type\SliderRangeType;

use Thrace\FormBundle\Form\Type\SliderType;

use Symfony\Component\Form\Tests\Extension\Core\Type\TextTypeTest;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

class SliderRangeTypeTest extends TextTypeTest
{

    public function testDefaultConfigs()
    {
        $form = $this->factory->create('thrace_slider_range');
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(
            'tpl' => 'slider.value.min: __value_1__ slider.value.max: __value_2__',
            'min' => 0,
            'max' => 100,
            'orientation' => 'horizontal',
            'width' => '300px',
            'first_name' => 'first_slider',
            'second_name' => 'second_slider',
            'range' => true,      
        ), $configs);
    }
    
    public function testVerticalConfigs()
    {
        $form = $this->factory->create('thrace_slider_range', null, array(
            'configs' => array('orientation' => 'vertical')        
        ));
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(
            'tpl' => 'slider.value.min: __value_1__ slider.value.max: __value_2__',
            'min' => 0,
            'max' => 100,
            'orientation' => 'vertical',
            'height' => '300px',
            'first_name' => 'first_slider',
            'second_name' => 'second_slider',
            'range' => true,      
        ), $configs);
    }

    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(new SliderType(), new SliderRangeType())
			)
    	);
    }
}