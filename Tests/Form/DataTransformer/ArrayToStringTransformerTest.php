<?php
namespace Thrace\FormBundle\Tests\Form\DataTransformer;

use Thrace\FormBundle\Form\DataTransformer\ArrayToStringTransformer;

use Thrace\ComponentBundle\Test\Tool\BaseTestCase;

class ArrayToStringTransformerTest extends BaseTestCase
{
    public function testTransform()
    {
        $transformer = new ArrayToStringTransformer();
        
        $this->assertNull($transformer->transform(''));
        $this->assertSame('one,two', $transformer->transform(array('one', 'two')));
    }
    
    public function testReserveTransform()
    {
        $transformer = new ArrayToStringTransformer();
       
        $this->assertSame(array('one', 'two'), $transformer->reverseTransform(array('one', 'two')));
        $this->assertSame(array('one', 'two'), $transformer->reverseTransform('one,two'));

    }
    
    public function testReserveTransformWithNullValue()
    {
        $transformer = new ArrayToStringTransformer();
       
        $this->assertSame(array(), $transformer->reverseTransform(null));
    }
}