<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Thrace\FormBundle\Form\Type\RecaptchaType;

use Symfony\Component\Form\Tests\Extension\Core\Type\TextTypeTest;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

class RecaptchaTypeTest extends TextTypeTest
{

    public function testDefaultConfigs()
    {
        $form = $this->factory->create('thrace_recaptcha');
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(), $configs);
    }
    
    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(new RecaptchaType(array()))
			)
    	);
    }
}