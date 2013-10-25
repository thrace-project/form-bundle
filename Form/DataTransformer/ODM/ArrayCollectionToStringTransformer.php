<?php
/*
 * This file is part of ThraceFormBundle
 *
 * (c) Nikolay Georgiev <symfonist@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Thrace\FormBundle\Form\DataTransformer\ODM;

use Thrace\FormBundle\Model\Select2SortableInterface\ODM;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\Common\Collections\Collection;

use Symfony\Component\PropertyAccess\PropertyAccess;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Form\DataTransformerInterface;

use Doctrine\ODM\MongoDB\PersistentCollection;

/**
 * Transforms array to string value
 *
 * @author Nikolay Georgiev <symfonist@gmail.com>
 * @since 1.0
 */
class ArrayCollectionToStringTransformer implements DataTransformerInterface
{
    protected $om;
    
    protected $inversedProperty;
    
    protected $referenceClass;
    
    protected $inversedClass;
    
    protected $collection;
    
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
    
    public function setInversedClass($inversedClass)
    {
        $this->inversedClass = $inversedClass;
    }
    
    public function setInversedProperty($inversedProperty)
    {
        $this->inversedProperty = $inversedProperty;
    }
    
    public function setReferenceClass($referenceClass)
    {
        $this->referenceClass = $referenceClass;
    }
    
    /**
     * {@inheritDoc}
     */
    public function transform($collection)
    {   
        if (!$collection instanceof Collection) {  
            return null; 
        }
        
        $data = array();
        $accessor = PropertyAccess::createPropertyAccessor();
        
        foreach ($collection as $ref){
            if (!$ref instanceof Select2SortableInterface){
                throw new \InvalidArgumentException('Reference class must be instance of Select2SortableInterface');  
            }
            
            $data[] = $accessor->getValue($ref, $this->inversedProperty)->getId();
        }
        
        $this->collection = $collection;
        
        return implode(',', $data);
    }

    /**
     * {@inheritDoc}
     */
    public function reverseTransform($value)
    {  
        if (empty($value)){
            return new ArrayCollection();
        }
        
        if ($this->collection instanceof PersistentCollection){
            foreach ($this->collection as $item){
                $this->om->remove($item);
            }  
            
            $this->collection->clear();
        }

        $data =  explode(',', $value);
        $referenceClass = $this->referenceClass;
        $setInversedProperty = sprintf('set%s', ucfirst($this->inversedProperty));
        
        foreach ($data as $idx => $id){
            $inversedObject = $this->om->find($this->inversedClass, (int) $id);
            $referenceObject = new $referenceClass();
            $referenceObject->{$setInversedProperty}($inversedObject);
            $referenceObject->setPosition($idx);
            $this->collection->add($referenceObject);  
        }
        
        return $this->collection;
    }
}