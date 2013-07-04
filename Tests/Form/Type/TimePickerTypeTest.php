<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Symfony\Component\Form\Tests\Extension\Core\Type\TypeTestCase;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

use Thrace\FormBundle\Form\Type\TimePickerType;

class TimePickerTypeTest extends TypeTestCase
{

    public function testDefaultConfigs()
    {
        $form = $this->factory->create('thrace_timepicker');
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(
            'showOn' => 'button',
            'buttonImageOnly' => true,
            'timeFormat' => 'HH:mm',
            'showSecond' => false
        ), $configs);
        $form->bind('20:11');
        $this->assertInstanceOf('\DateTime', $form->getData());
        $this->assertSame('20:11', $form->getData()->format('H:i'));
    }

    public function testWithSeconds()
    {
        $form = $this->factory->create('thrace_timepicker', null, array(
            'with_seconds' => true
       ));
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(
            'showOn' => 'button',
            'buttonImageOnly' => true,
            'timeFormat' => 'HH:mm:ss',
            'showSecond' => true,
        ), $configs);
        $form->bind('20:11:21');
        $this->assertInstanceOf('\DateTime', $form->getData());
        $this->assertSame('20:11:21', $form->getData()->format('H:i:s'));
    }

    public function testInputString()
    {
        $form = $this->factory->create('thrace_timepicker', null, array(
            'input' => 'string'
        ));

        $form->bind('20:11');
        $this->assertSame('20:11', $form->getData());
    }

    public function testInputTimestamp()
    {
        $form = $this->factory->create('thrace_timepicker', null, array(
            'input' => 'timestamp'
        ));

        $form->bind('20:11'); 
        $this->assertSame(strtotime('1970-01-01 20:11'), $form->getData());
    }

    public function testInputArray()
    {
        $form = $this->factory->create('thrace_timepicker', null, array(
            'input' => 'array'
        ));

        $form->bind('20:11');
        $this->assertSame(array('hour' => '20','minute' => '11'), $form->getData());
    }

    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(new TimePickerType())
			)
    	);
    }

}