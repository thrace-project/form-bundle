<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Thrace\FormBundle\Form\Type\DatePickerType;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

use Symfony\Component\Form\Tests\Extension\Core\Type\TypeTestCase;

class DatePickerTypeTest extends TypeTestCase
{

    public function testConfig()
    {

        $configs = array();
        
        $form = $this->factory->create('thrace_datepicker', null, array(
            'configs' => $configs,
        ));

        $view = $form->createView();
        $options = $form->getConfig()->getOptions();
        $this->assertSame('Y-m-d', $options['format']);
        $this->assertSame(array('showOn' => 'button', 'buttonImageOnly' => true, 'dateFormat' => 'yy-mm-dd'), $view->vars['configs']);
    }
    
    public function testDateTime()
    {
        $configs = array();
        
        $form = $this->factory->create('thrace_datepicker', null, array(
            'configs' => $configs,
        ));

        $form->bind('2012-12-21');
        
        $this->assertInstanceOf('\DateTime', $form->getData());
        $this->assertSame('2012-12-21', $form->getData()->format('Y-m-d'));
    }
    
    public function testString()
    {

        $configs = array();
        
        $form = $this->factory->create('thrace_datepicker', null, array(
            'input' => 'string',
            'configs' => $configs,
        ));

        $form->bind('2012-12-21');
        
        $this->assertSame('2012-12-21', $form->getData());
    }
    
    public function testTimestamp()
    {

        $configs = array();
        
        $form = $this->factory->create('thrace_datepicker', null, array(
            'input' => 'timestamp',
            'configs' => $configs,
        ));

        $form->bind('2012-12-21');
        
        $this->assertSame(strtotime('2012-12-21'), $form->getData());
    }
    
    public function testArray()
    {

        $configs = array();
        
        $form = $this->factory->create('thrace_datepicker', null, array(
            'input' => 'array',
            'configs' => $configs,
        ));

        $form->bind('2012-12-21');
        
        $this->assertSame(array('year' => '2012','month' => '12','day' => '21'), $form->getData());
    }
    

    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(new DatePickerType())
			)
    	);
    }

}