<?php
namespace Thrace\FormBundle\Tests\Form\ChoiceList;

use Thrace\FormBundle\Form\ChoiceList\AjaxChoiceList;

use Thrace\ComponentBundle\Test\Tool\BaseTestCase;

class AjaxChoiceListTest extends BaseTestCase
{
    public function testDefault()
    {
        $choiceList = new AjaxChoiceList(array());
        
        $this->assertSame(array('value'), $choiceList->getValuesForChoices(array('value')));
        
        $this->assertSame(array('label'), $choiceList->getChoicesForValues(array('label')));
    }
}