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

use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\ORM\Proxy\Proxy;

use Symfony\Component\Form\Exception\UnexpectedTypeException;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Model form transformer
 *
 * @author Nikolay Georgiev <azazen09@gmail.com>
 * @since 1.0
 */
class DoctrineORMTransformer implements DataTransformerInterface
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $om;
    
    /**
     * @var string
     */
    protected $class;
    
    /**
     * Construct
     * 
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
    
    /**
     * Inversed class name
     * 
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\DataTransformerInterface::transform()
     */
    public function transform($entity)
    {   
        if (null === $entity || '' === $entity) {
            return null;
        }
        
        if (!is_object($entity)){
            throw new UnexpectedTypeException($entity, 'object');
        }
        
        if ($entity instanceof Proxy && !$entity->__isInitialized()){
            $entity->__load();
        }

        $meta = $this->om->getClassMetadata(get_class($entity));
        $id = $meta->getSingleIdReflectionProperty()->getValue($entity);

        return $id;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\DataTransformerInterface::reverseTransform()
     */
    public function reverseTransform($value)
    {  
        if (null === $value || '' === $value) {
            return null;
        }
        
        return $this->om->getReference($this->class, $value);

    }
}