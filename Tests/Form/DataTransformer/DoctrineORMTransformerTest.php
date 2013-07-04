<?php
namespace Thrace\FormBundle\Tests\Form\DataTransformer;

use Thrace\FormBundle\Tests\Fixture\Entity\Product;

use Thrace\FormBundle\Form\DataTransformer\DoctrineORMTransformer;

use Thrace\ComponentBundle\Test\Tool\BaseTestCaseORM;

use Thrace\ComponentBundle\Test\Tool\BaseTestCase;

class DoctrineORMTransformerTest extends BaseTestCaseORM
{
    const FIXTURE_PRODUCT = 'Thrace\FormBundle\Tests\Fixture\Entity\Product';
    
    protected function setUp()
    {
        $this->createMockEntityManager();
    }
    
    public function testTransformWithNull()
    {
        $transformer = new DoctrineORMTransformer($this->em);
        $transformer->setClass(self::FIXTURE_PRODUCT);
        
        $this->assertNull($transformer->transform(null));
    }
    
    public function testTransformWithInvalidValue()
    {
        $transformer = new DoctrineORMTransformer($this->em);
        $transformer->setClass(self::FIXTURE_PRODUCT);
        
        $this->setExpectedException('Symfony\Component\Form\Exception\UnexpectedTypeException');
        $transformer->transform('invalid');        
    }
    
    public function testTransform()
    {
        $this->populate();
        $this->em->clear();
        
        $transformer = new DoctrineORMTransformer($this->em);
        $transformer->setClass(self::FIXTURE_PRODUCT);
        
        $entity = $this->em->getReference(self::FIXTURE_PRODUCT, 1);
      
        $result = $transformer->transform($entity);    
        $this->assertSame(1, $result);
    }
    
    public function testReverveTransformerWithNull()
    {
        $transformer = new DoctrineORMTransformer($this->em);
        $transformer->setClass(self::FIXTURE_PRODUCT);
        
        $this->assertNull($transformer->reverseTransform(null));
    }
    
    public function testReverveTransformer()
    {
        $this->populate();
        $this->em->clear();
        
        $transformer = new DoctrineORMTransformer($this->em);
        $transformer->setClass(self::FIXTURE_PRODUCT);

        $this->assertInstanceOf('EntityProxy\__CG__\Thrace\FormBundle\Tests\Fixture\Entity\Product', $transformer->reverseTransform(1));
    }
    
    protected function populate()
    {
        $project = new Product();
        $project->setTitle('product1');
        $this->em->persist($project);
        $this->em->flush();
    }
    
    protected function getUsedEntityFixtures()
    {
        return array(self::FIXTURE_PRODUCT);
    }
    
}