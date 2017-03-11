<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Symfony\Component\Form\Tests\Extension\Core\Type\TextTypeTest;

use Thrace\FormBundle\Form\Type\DatePickerType;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

use Thrace\FormBundle\Form\Type\DateRangePickerType;

class DateRangePickerTypeTest extends TextTypeTest
{


    public function testDefault()
    {
        $form = $this->factory->create(DateRangePickerType::class);

        $form->submit(array('first_date' => '2012-12-21', 'second_date' => '2012-12-22'));
        $form->createView();
        $data = $form->getData();

        $this->assertCount(2, $data);
        $this->assertInstanceOf('\DateTime', $data['first_date']);
        $this->assertInstanceOf('\DateTime', $data['second_date']);
    }


    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(
				    new DateRangePickerType(),
				    new DatePickerType()
				)
			)
    	);
    }

}