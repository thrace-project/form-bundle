<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Thrace\FormBundle\Form\Type\ToggleButtonType;

use Symfony\Component\Form\Tests\Extension\Core\Type\TypeTestCase;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

class ToggleButtonTypeTest extends TypeTestCase
{

    public function testDefaultConfigs()
    {
        $form = $this->factory->create('thrace_toggle_button');
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(
            'checked_label' => 'label.checked',
            'unchecked_label' => 'label.unchecked' 
        ), $configs);
    }
    
    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(new ToggleButtonType())
			)
    	);
    }
}