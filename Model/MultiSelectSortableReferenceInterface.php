<?php
/*
 * This file is part of ThraceFormBundle
 *
 * (c) Nikolay Georgiev <symfonist@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Thrace\FormBundle\Model;

/**
 * Interface that implements MultiSelectSortableReference class
 *
 * @author Nikolay Georgiev <symfonist@gmail.com>
 * @since 1.0
 */
interface MultiSelectSortableReferenceInterface
{
    /**
     * Gets the id 
     * 
     * @return mixed
     */
    public function getId();
    
    /**
     * Gets the label of inversed entity
     * 
     * @return string
     */
    public function getLabel();
    
    /**
     * 
     * Sets the position
     * 
     * @param integer $position
     */
    public function setPosition($position);
    
    /**
     * Gets the position
     * 
     * @return integer
     */
    public function getPosition();
    
}