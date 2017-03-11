<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Thrace\FormBundle\Form\Type\ButtonsetType;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

use Symfony\Component\Form\Tests\Extension\Core\Type\ButtonTypeTest;

class ButtonsetTypeTest extends ButtonTypeTest
{

    public function testConfig()
    {

        $configs = array();
        
        $form = $this->factory->create(ButtonsetType::class, null, array(
            'configs' => $configs,
        ));

        $view = $form->createView();

        $this->assertEquals(array(), $view->vars['configs']);
    }

    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(new ButtonsetType('choice'))
			)
    	);
    }

}