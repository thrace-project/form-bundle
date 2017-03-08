<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Thrace\FormBundle\Form\Type\ColorPickerType;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

use Symfony\Component\Form\Tests\Extension\Core\Type\TextTypeTest;

class ColorPickerTypeTest extends TextTypeTest
{

    public function testConfig()
    {

        $configs = array();
        
        $form = $this->factory->create(ColorPickerType::class, null, array(
            'configs' => $configs,
        ));

        $view = $form->createView();

        $this->assertEquals(array(), $view->vars['configs']);
    }

    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(new ColorPickerType())
			)
    	);
    }

}