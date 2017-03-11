<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Thrace\FormBundle\Form\Type\RatingType;

use Symfony\Component\Form\Tests\Extension\Core\Type\TextTypeTest;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

class RatingTypeTest extends TextTypeTest
{

    public function testDefaultConfigs()
    {
        $form = $this->factory->create(RatingType::class, null, array('configs' => array('path' => 'path_to_images')));
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(
            'path' => 'path_to_images'
        ), $configs);
    }
    
    public function testInvalidConfigs()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $form = $this->factory->create(RatingType::class);
    }

    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(new RatingType())
			)
    	);
    }
}