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

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Form\Exception\UnexpectedTypeException;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Model form transformer
 *
 * @author Nikolay Georgiev <symfonist@gmail.com>
 * @since 1.0
 */
class DoctrineTransformer implements DataTransformerInterface
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
     * {@inheritDoc}
     */
    public function transform($object)
    {   
        if (null === $object || '' === $object) {
            return null;
        }
        
        if (!is_object($object)){
            throw new UnexpectedTypeException($object, 'object');
        }

        $meta = $this->om->getClassMetadata(get_class($object));
        $id = $meta->getSingleIdReflectionProperty()->getValue($object);

        return $id;
    }
    
    /**
     * {@inheritDoc}
     */
    public function reverseTransform($value)
    {  
        if (null === $value || '' === $value) {
            return null;
        }
        
        return $this->om->find($this->class, $value);
    }
}