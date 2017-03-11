<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Thrace\FormBundle\Form\Type\CollectionType;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

use Symfony\Component\Form\Tests\Extension\Core\Type\CollectionTypeTest as TypeTest;

class CollectionTypeTest extends TypeTest
{

    public function testConfig()
    {

        $configs = array();
        
        $form = $this->factory->create(CollectionType::class, null, array(
            'configs' => $configs,
        ));


        $view = $form->createView();

        $this->assertEquals(array(
            'empty_text' => 'collection.empty',
            'empty_text_class' => '',
            'add_button_text' => 'button.add',
            'add_button_class' => '',
            'remove_button_text' => 'button.remove',
            'remove_button_class' => '',
            'fieldset_class' => ''
        ), $view->vars['configs']);
    }

    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(new CollectionType())
			)
    	);
    }

}