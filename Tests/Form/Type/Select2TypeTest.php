<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Thrace\FormBundle\Form\Type\Select2Type;

use Symfony\Component\Form\Tests\Extension\Core\Type\TextTypeTest;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

class Select2TypeTest extends TextTypeTest
{

    public function testDefaultConfigs()
    {
        $form = $this->factory->create(Select2Type::class);
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(
            'width' => '300px',
            'allowClear' => true,
            'placeholder' => 'select.empty_value'
        ), $configs);
    }

    public function testAjaxAndMultiple()
    {
        $form = $this->factory->create(Select2Type::class, null, array(
            'multiple' => true,
            'configs' => array('ajax' => array())
        ));
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(
            'width' => '300px',
            'allowClear' => true,
            'ajax' => array (),
            'placeholder' => 'select.empty_value',
            'multiple' => true,
        ), $configs);
    }
    
    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(
			        new Select2Type($this->getMockTransformer(), 'choice'), 
			        new Select2Type($this->getMockTransformer(), 'ajax')
		        )
			)
    	);
    }
    
    private function getMockTransformer()
    {
        return $this->createMock('Symfony\Component\Form\DataTransformerInterface');
    }
}