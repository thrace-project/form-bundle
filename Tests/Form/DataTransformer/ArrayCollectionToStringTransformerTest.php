<?php
namespace Thrace\FormBundle\Tests\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;

use Thrace\FormBundle\Tests\Fixture\Entity\ProjectReference;

use Thrace\FormBundle\Tests\Fixture\Entity\Project;

use Thrace\FormBundle\Tests\Fixture\Entity\ShowCase;

use Thrace\FormBundle\Form\DataTransformer\ArrayCollectionToStringTransformer;

use Thrace\FormBundle\Tests\Fixture\Entity\Product;

use Thrace\ComponentBundle\Test\Tool\BaseTestCaseORM;

use Thrace\ComponentBundle\Test\Tool\BaseTestCase;

class ArrayCollectionToStringTransformerTest extends BaseTestCaseORM
{
    const FIXTURE_PROJECT = 'Thrace\FormBundle\Tests\Fixture\Entity\Project';
    const FIXTURE_SHOWCASE = 'Thrace\FormBundle\Tests\Fixture\Entity\ShowCase';
    const FIXTURE_PROJECT_REFERENCE = 'Thrace\FormBundle\Tests\Fixture\Entity\ProjectReference';
    
    protected function setUp()
    {
        $this->createMockEntityManager();
    }
    
    public function testTransform()
    {
        $this->populate();
        $this->em->clear();
        
        $transformer = new ArrayCollectionToStringTransformer($this->em);
        $transformer->setReferenceClass(self::FIXTURE_PROJECT_REFERENCE);
        $transformer->setInversedClass(self::FIXTURE_PROJECT);
        $transformer->setInversedProperty('project');
        
        $showcase = $this->em->getReference(self::FIXTURE_SHOWCASE, 1);
      
        $result = $transformer->transform($showcase->getProjectReferences());    
        $this->assertSame('1', $result);
    }
    
    public function testTransformWithNull()
    {
        $this->populate();
        $this->em->clear();
        
        $transformer = new ArrayCollectionToStringTransformer($this->em);
        $transformer->setReferenceClass(self::FIXTURE_PROJECT_REFERENCE);
        $transformer->setInversedClass(self::FIXTURE_PROJECT);
        $transformer->setInversedProperty('project');
        
        $showcase = $this->em->getReference(self::FIXTURE_SHOWCASE, 1);
      
        $result = $transformer->transform(null);    
        $this->assertNull($result);
    }
    
    public function testTransformWithInvalidEntityInCollection()
    {
        $this->populate();
        $this->em->clear();
        
        $transformer = new ArrayCollectionToStringTransformer($this->em);
        $transformer->setReferenceClass(self::FIXTURE_PROJECT_REFERENCE);
        $transformer->setInversedClass(self::FIXTURE_PROJECT);
        $transformer->setInversedProperty('project');
        
        $showcase = $this->em->getReference(self::FIXTURE_SHOWCASE, 1);
      
        $collection = new ArrayCollection();
        $collection->add(new Product());
        
        $this->setExpectedException('\InvalidArgumentException');
        $result = $transformer->transform($collection);    
    }
    

    public function testReserveTransform()
    {
        $this->populate();
        $this->em->clear();
    
        $transformer = new ArrayCollectionToStringTransformer($this->em);
        $transformer->setReferenceClass(self::FIXTURE_PROJECT_REFERENCE);
        $transformer->setInversedClass(self::FIXTURE_PROJECT);
        $transformer->setInversedProperty('project');
    
        $showcase = $this->em->getReference(self::FIXTURE_SHOWCASE, 1);
        $reference = $showcase->getProjectReferences()->first();
        $this->assertInstanceOf(
            'Thrace\FormBundle\Model\Select2SortableInterface', 
            $reference
        );
        
        $this->assertSame('project1', $reference->getLabel());
        $this->assertSame(0, $reference->getPosition());
        
        $transformer->transform($showcase->getProjectReferences());
        
        $result = $transformer->reverseTransform('1,2,3');
        $this->assertCount(3, $result);
    }
    
    public function testReserveTransformWithNull()
    {
        $this->populate();
        $this->em->clear();
    
        $transformer = new ArrayCollectionToStringTransformer($this->em);
        $transformer->setReferenceClass(self::FIXTURE_PROJECT_REFERENCE);
        $transformer->setInversedClass(self::FIXTURE_PROJECT);
        $transformer->setInversedProperty('project');
    
        $showcase = $this->em->getReference(self::FIXTURE_SHOWCASE, 1);
        
        $result = $transformer->reverseTransform(null);
        $this->assertInstanceOf('\Doctrine\Common\Collections\ArrayCollection', $result);
        $this->assertCount(0, $result);
    }
    
    protected function populate()
    {
        $showcase = new ShowCase();
        $showcase->setTitle('showcase1');
        $this->em->persist($showcase);
        
        $project1 = new Project();
        $project1->setTitle('project1');
        $this->em->persist($project1);
        
        $project2 = new Project();
        $project2->setTitle('project2');
        $this->em->persist($project2);
        
        $project3 = new Project();
        $project3->setTitle('project3');
        $this->em->persist($project3);
        
        $projectReference = new ProjectReference();
        $projectReference->setPosition(0);
        $projectReference->setProject($project1);
        $showcase->addProjectReference($projectReference);
        
        $this->em->flush();
    }
    
    protected function getUsedEntityFixtures()
    {
        return array(self::FIXTURE_SHOWCASE, self::FIXTURE_PROJECT, self::FIXTURE_PROJECT_REFERENCE);
    }
    
}