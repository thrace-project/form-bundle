<?php
/*
 * This file is part of ThraceFormBundle
 *
 * (c) Nikolay Georgiev <symfonist@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Thrace\FormBundle\Form\Type;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\DataTransformerInterface;

use Symfony\Component\Form\FormView;

use Symfony\Component\OptionsResolver\Options;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\AbstractType;

/**
 * This class creates jquery multi select sortable element
 *
 * @author Nikolay Georgiev <symfonist@gmail.com>
 * @since 1.0
 */
class Select2SortableType extends AbstractType
{
    
    /**
     * @var DataTransformerInterface
     */
    protected $dataTransformer;
    
    /**
     * Construct
     * 
     * @param EventSubscriberInterface $eventSubscriber
     */
    public function __construct(DataTransformerInterface $dataTransformer)
    {
        $this->dataTransformer = $dataTransformer;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Symfony\Component\Form\AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->dataTransformer->setReferenceClass($options['reference_class']);
        $this->dataTransformer->setInversedClass($options['inversed_class']);
        $this->dataTransformer->setInversedProperty($options['inversed_property']);
        
        $builder->addModelTransformer($this->dataTransformer);
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildView()
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['configs'] = $options['configs'];
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $defaultConfigs = array();
        
        $resolver->setDefaults(array(
            'translation_domain' => 'ThraceFormBundle',
            'by_reference' => false,
            'configs' => $defaultConfigs,
        ));
        
        $resolver->setNormalizers(array(
            'configs' => function (Options $options, $value) use ($defaultConfigs){
                $configs = array_replace_recursive($defaultConfigs, $value);
                return $configs;
            }
        ));
          
        $resolver->setRequired(array('reference_class', 'inversed_class', 'inversed_property'));
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::getParent()
     */
    public function getParent()
    {
        return TextType::class;
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getBlockPrefix()
    {
        return 'thrace_select2_sortable';
    }
}
