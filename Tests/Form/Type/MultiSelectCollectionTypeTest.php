<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Thrace\FormBundle\Form\Type\MultiSelectType;

use Thrace\FormBundle\Form\Type\MultiSelectCollectionType;

use Symfony\Component\Form\Tests\Extension\Core\Type\TypeTestCase;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

class MultiSelectCollectionTypeTest extends TypeTestCase
{

    protected function setUp()
    {   
        parent::setUp();
        
        if (!interface_exists('Thrace\DataGridBundle\DataGrid\DataGridInterface')) {
            $this->markTestSkipped('DataGridBundle is not available');
        }
    }
    
    public function testDefaultConfigs()
    {
        $form = $this->factory->create('thrace_multi_select_collection', null, array(
            'grid' => $this->createMockDataGrid(),
            'options' => array(
                'class' => 'Thrace\FormBundle\Tests\Fixture\Entity\Product'        
            ),
        ));
        
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array(), $configs);
    }
    
    public function testWithInvalidDataGrid()
    {
        $this->setExpectedException('InvalidArgumentException');
        $form = $this->factory->create('thrace_multi_select_collection', null, array(
            'grid' => new \stdClass(),      
        ));
        
        $form->createView();
    }
    
    public function testWithInvalidMethodIsMultiSelectEnabled()
    {
        $this->setExpectedException('InvalidArgumentException');
        $form = $this->factory->create('thrace_multi_select_collection', null, array(
            'grid' => $this->createMockDataGrid(false),      
        ));
        
        $form->createView();
    }
    
    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(
			        new MultiSelectCollectionType(),
				    new MultiSelectType($this->createMockTransformer())
		        )
			)
    	);
    }
    
    protected function createMockTransformer()
    {
        $mock = $this
            ->getMockBuilder('Thrace\FormBundle\Form\DataTransformer\DoctrineORMTransformer')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        
        $mock
            ->expects($this->any())
            ->method('setClass')
            ->with('Thrace\FormBundle\Tests\Fixture\Entity\Product')
        ;
    
        return $mock;
    }
    
    protected function createMockDataGrid($multiSelectSortableEnabled = true)
    {
        $mock = $this->getMock('Thrace\DataGridBundle\DataGrid\DataGridInterface');;
    
        $mock
            ->expects($this->any())
            ->method('isMultiSelectEnabled')
            ->will($this->returnValue($multiSelectSortableEnabled))
        ;

        return $mock;
    }
}