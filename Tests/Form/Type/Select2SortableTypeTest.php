<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Thrace\FormBundle\Form\Type\Select2SortableType;

use Thrace\FormBundle\Form\Type\Select2Type;

use Symfony\Component\Form\Tests\Extension\Core\Type\TextTypeTest;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

class Select2SortableTypeTest extends TextTypeTest
{

    public function testDefaultConfigs()
    {
        $form = $this->factory->create(Select2SortableType::class, null, array(
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
			        new Select2SortableType($this->getMockBuilderTransformer()),
		        )
			)
    	);
    }
    
    private function getMockBuilderTransformer()
    {
        $mock = $this
            ->createMock('Thrace\FormBundle\Form\DataTransformer\ArrayCollectionToStringTransformer')

        ;

        return $mock;
    }
}