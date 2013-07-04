<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Thrace\FormBundle\Form\Type\AutocompleteType;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

use Symfony\Component\Form\Tests\Extension\Core\Type\TypeTestCase;

class AutocompleteTypeTest extends TypeTestCase
{

    public function testInvalidConfigs()
    {
        $this->setExpectedException('InvalidArgumentException');
        $form = $this->factory->create('thrace_autocomplete');

    }

    public function testConfig()
    {

        $configs = array(
            'source' => 'autocomplete_route'
        );
        $form = $this->factory->create('thrace_autocomplete', null, array(
            'configs' => $configs,
        ));

        $view = $form->createView();

        $this->assertEquals(array_merge(array('use_categories' => false), $configs), $view->vars['configs']);
    }

    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(new AutocompleteType())
			)
    	);
    }

}