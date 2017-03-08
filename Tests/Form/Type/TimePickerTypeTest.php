<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Symfony\Component\Form\Tests\Extension\Core\Type\TextTypeTest;

use Thrace\FormBundle\Form\Type\TimePickerType;
use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;


class TimePickerTypeTest extends TextTypeTest
{

    public function testDefaultConfigs()
    {
        $form = $this->factory->create(TimePickerType::class);
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(
            'showOn' => 'button',
            'buttonImageOnly' => true,
            'timeFormat' => 'HH:mm',
            'showSecond' => false
        ), $configs);
        $form->submit('20:11');
        $this->assertInstanceOf('\DateTime', $form->getData());
        $this->assertSame('20:11', $form->getData()->format('H:i'));
    }

    public function testWithSeconds()
    {
        $form = $this->factory->create(TimePickerType::class, null, array(
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
        $form->submit('20:11:21');
        $this->assertInstanceOf('\DateTime', $form->getData());
        $this->assertSame('20:11:21', $form->getData()->format('H:i:s'));
    }

    public function testInputString()
    {
        $form = $this->factory->create(TimePickerType::class, null, array(
            'input' => 'string'
        ));

        $form->submit('20:11');
        $this->assertSame('20:11', $form->getData());
    }

    public function testInputTimestamp()
    {
        $form = $this->factory->create(TimePickerType::class, null, array(
            'input' => 'timestamp'
        ));

        $form->submit('20:11');
        $this->assertSame(strtotime('1970-01-01 20:11'), $form->getData());
    }

    public function testInputArray()
    {
        $form = $this->factory->create(TimePickerType::class, null, array(
            'input' => 'array'
        ));

        $form->submit('20:11');
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