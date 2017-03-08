<?php
namespace Thrace\FormBundle\Tests\Form\Type;

use Thrace\FormBundle\Form\Type\MultiSelectType;

use Thrace\FormBundle\Form\Type\MultiSelectCollectionType;

use Symfony\Component\Form\Tests\Extension\Core\Type\CollectionTypeTest;

use Thrace\FormBundle\Tests\Form\Extension\TypeExtensionTest;

class MultiSelectCollectionTypeTest extends CollectionTypeTest
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
        $form = $this->factory->create(MultiSelectCollectionType::class, null, array(
            'grid' => $this->createMockDataGrid(),
            'options' => array(
                'class' => 'Thrace\FormBundle\Tests\Fixture\Entity\Product'        
            ),
        ));
        
        $view = $form->createView();
        $configs = $view->vars['configs'];
        $this->assertSame(array('datagrid_exists' => true), $configs);
    }
    
    public function testWithInvalidDataGrid()
    {
        $this->setExpectedException('InvalidArgumentException');
        $form = $this->factory->create(MultiSelectCollectionType::class, null, array(
            'grid' => new \stdClass(),      
        ));
        
        $form->createView();
    }
    
    public function testWithInvalidMethodIsMultiSelectEnabled()
    {
        $this->setExpectedException('InvalidArgumentException');
        $form = $this->factory->create(MultiSelectCollectionType::class, null, array(
            'grid' => $this->createMockDataGrid(false),      
        ));
        
        $form->createView();
    }
    
    protected function getExtensions()
    {
    	return array(
			new TypeExtensionTest(
				array(
			        new MultiSelectCollectionType(true),
				    new MultiSelectType($this->createMockTransformer())
		        )
			)
    	);
    }
    
    protected function createMockTransformer()
    {
        $mock = $this
            ->createMock('Thrace\FormBundle\Form\DataTransformer\DoctrineORMTransformer')

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
        $mock = $this->createMock('Thrace\DataGridBundle\DataGrid\DataGridInterface');;
    
        $mock
            ->expects($this->any())
            ->method('isMultiSelectEnabled')
            ->will($this->returnValue($multiSelectSortableEnabled))
        ;

        return $mock;
    }
}