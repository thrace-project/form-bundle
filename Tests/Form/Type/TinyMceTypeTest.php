<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Thrace\FormBundle\Form\Type\TinyMceType;

use Symfony\Component\Form\Tests\Extension\Core\Type\TextTypeTest;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

class TinyMceTypeTest extends TextTypeTest
{

    public function testDefaultConfigs()
    {
        $form = $this->factory->create('thrace_tinymce');
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(
            'readonly' => false,
        ), $configs);
    }

    protected function getExtensions()
    {
        return array(
            new TypeExtensionTest(
                array(
                    new TinyMceType(
                		array('readonly' => false)
                    )
                )
            )
        );
    }
}