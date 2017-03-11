<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Symfony\Component\Form\Tests\Extension\Core\Type\ChoiceTypeTest;
use Thrace\FormBundle\Form\Type\ToggleButtonType;
use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

class ToggleButtonTypeTest extends ChoiceTypeTest
{

    public function testDefaultConfigs()
    {
        $form = $this->factory->create(ToggleButtonType::class);
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