<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Thrace\FormBundle\Form\Type\Select2SortableType;

use Thrace\FormBundle\Form\Type\Select2Type;

use Symfony\Component\Form\Tests\Extension\Core\Type\TypeTestCase;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

class Select2SortableTypeTest extends TypeTestCase
{

    public function testDefaultConfigs()
    {
        $form = $this->factory->create('thrace_select2_sortable', null, array(
            'reference_class' => 'ReferenceClass',        
            'inversed_class' => 'InversedClass',        
            'inversed_property' => 'InversedProperty',        
        ));
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(

        ), $configs);
    }

    
    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(
			        new Select2SortableType($this->getMockTransformer()), 
		        )
			)
    	);
    }
    
    private function getMockTransformer()
    {
        $mock = $this
            ->getMockBuilder('Thrace\FormBundle\Form\DataTransformer\ArrayCollectionToStringTransformer')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        
        $mock
            ->expects($this->once())
            ->method('setReferenceClass')
            ->with('ReferenceClass')
        ;
        
        $mock
            ->expects($this->once())
            ->method('setInversedClass')
            ->with('InversedClass')
        ;
        
        $mock
            ->expects($this->once())
            ->method('setInversedProperty')
            ->with('InversedProperty')
        ;
        
        return $mock;
    }
}