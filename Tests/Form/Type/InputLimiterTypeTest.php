<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Symfony\Component\Form\Tests\Extension\Core\Type\TextTypeTest;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

use Thrace\FormBundle\Form\Type\InputLimiterType;

class InputLimiterTypeTest extends TextTypeTest
{

    public function testDefaultConfigs()
    {
        $form = $this->factory->create(InputLimiterType::class);
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(
            'limit' => 255,
            'type' => 'textarea'
        ), $configs);
    }

    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(new InputLimiterType())
			)
    	);
    }
}