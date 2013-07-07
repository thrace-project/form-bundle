<?php
/*
 * This file is part of ThraceFormBundle
 *
 * (c) Nikolay Georgiev <symfonist@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Thrace\FormBundle\Form\DataTransformer;

use Thrace\FormBundle\Model\Select2SortableInterface;

use Doctrine\ORM\PersistentCollection;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\Common\Collections\Collection;

use Symfony\Component\PropertyAccess\PropertyAccess;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Form\DataTransformerInterface;

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
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\DataTransformerInterface::transform()
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
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\DataTransformerInterface::reverseTransform()
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
        
        foreach ($data as $idx => $id){
            $inversedObject = $this->om->getReference($this->inversedClass, (int) $id);
            $referenceObject = new $referenceClass();
            $referenceObject->setProject($inversedObject);
            $referenceObject->setPosition($idx);
            $this->collection->add($referenceObject);  
        }
        
        return $this->collection;
    }
}