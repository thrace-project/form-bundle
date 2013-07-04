<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Symfony\Component\Form\Tests\Extension\Core\Type\TypeTestCase;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

use Thrace\FormBundle\Form\Type\DateTimePickerType;

class DateTimePickerTypeTest extends TypeTestCase
{
    public function testDefaultConfig()
    {
        $form = $this->factory->create('thrace_datetimepicker');
        $form->bind('2012-12-21 10:22');
        $view = $form->createView();

        $configs = $view->vars['configs'];

        $this->assertEquals(
            array(
                'showOn'     => 'button',
                'buttonImageOnly' => true,
                'showSecond' => false,
                'timeFormat' => 'HH:mm',
                'dateFormat' => 'yy-mm-dd'
            ),
            $configs
        );

        $this->assertInstanceOf('\DateTime', $form->getData());
        $this->assertSame('2012-12-21 10:22', $form->getData()->format('Y-m-d H:i'));
    }

    public function testWithSeconds()
    {
        $form = $this->factory->create('thrace_datetimepicker', null, array(
            'with_seconds' => true,
        ));
        $form->bind('2012-12-21 10:22:21');
        $view = $form->createView();

        $configs = $view->vars['configs'];

        $this->assertEquals(
            array(
                'showOn'     => 'button',
                'buttonImageOnly' => true,
                'showSecond' => true,
                'timeFormat' => 'HH:mm:ss',
                'dateFormat' => 'yy-mm-dd'
            ),
            $configs
        );

        $this->assertInstanceOf('\DateTime', $form->getData());
        $this->assertSame('2012-12-21 10:22:21', $form->getData()->format('Y-m-d H:i:s'));
    }

    public function testInputString()
    {
        $form = $this->factory->create('thrace_datetimepicker', null, array(
            'with_seconds' => true,
            'input' => 'string'
        ));
        $form->bind('2012-12-21 10:22:21');

        $this->assertSame('2012-12-21 10:22:21', $form->getData());
    }

    public function testInputTimestamp()
    {
        $form = $this->factory->create('thrace_datetimepicker', null, array(
            'with_seconds' => true,
            'input' => 'timestamp'
        ));
        $form->bind('2012-12-21 10:22:21');

        $this->assertSame(strtotime('2012-12-21 10:22:21'), $form->getData());
    }

    public function testInputArray()
    {
        $form = $this->factory->create('thrace_datetimepicker', null, array(
            'with_seconds' => true,
            'input' => 'array'
        ));
        $form->bind('2012-12-21 10:22:21');

        $this->assertSame(
            array(
                'year' => '2012',
                'month' => '12',
                'day' => '21',
                'hour' => '10',
                'minute' => '22',
                'second' => '21'
            ), $form->getData());
    }

    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(new DateTimePickerType())
			)
    	);
    }

}