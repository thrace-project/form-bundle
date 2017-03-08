<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Thrace\FormBundle\Form\Type\Select2Type;

use Thrace\FormBundle\Form\Type\Select2DependentType;

use Symfony\Component\Form\Tests\Extension\Core\Type\TextTypeTest;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

class Select2DependentTypeTest extends TextTypeTest
{

    public function testDefaultConfigs()
    {
        $form = $this->factory->create('thrace_select2_dependent', null, array(
            'choices' => array('value1' => 'label1', 'value2' => 'label2'), 
            'dependent_source' => 'ajax_route'
        ));
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(
            'dependent_value' => null,
            'first_name' => 'first_name',
            'second_name' => 'second_name',
            'dependent_source' => 'ajax_route',
            'multiple' => false,
        ), $configs);
    }

    
    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(
			        new Select2Type($this->getMockTransformer(), 'choice'), 
			        new Select2DependentType(), 
		        )
			)
    	);
    }
    
    private function getMockTransformer()
    {
        return $this->getMock('Symfony\Component\Form\DataTransformerInterface');
    }
}