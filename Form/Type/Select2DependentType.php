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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Thrace\FormBundle\Form\ChoiceList\AjaxChoiceList;

/**
 * This class creates jquery select2 element with two field
 *
 * @author Nikolay Georgiev <symfonist@gmail.com>
 * @since  1.0
 */
class Select2DependentType extends AbstractType
{

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add($options['first_name'], Select2Type::class, $options['first_options'])
            ->add($options['second_name'], Select2Type::class, $options['second_options']);
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildView()
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $data                  = $form->getData();
        $view->vars['configs'] = array_merge(
            array(
                'dependent_value' => isset($data[ $options['second_name'] ]) ? $data[ $options['second_name'] ] : null,
            ), $options['configs']);

    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $choiceList = new AjaxChoiceList(array());

        $resolver->setDefaults(
            array(
                'first_options'      => array(),
                'second_options'     => array(),
                'error_bubbling'     => false,
                'first_name'         => 'first_name',
                'second_name'        => 'second_name',
                'widget'             => 'choice',
                'translation_domain' => 'ThraceFormBundle',
                'multiple'           => false,
                'choices'            => array(),
                'configs'            => array(),
            ));


        $resolver->setNormalizer(
            'first_options', function (Options $options, $value) {
            $value['choices'] = $options->get('choices');

            return $value;
        });
        $resolver->setNormalizer(
            'second_options', function (Options $options, $value) use ($choiceList) {
            $value['choices'] = array();
            $value['multiple']    = $options->get('multiple');

            return $value;
        });

        $resolver->setNormalizer(
            'configs', function (Options $options, $value) {
            $value['first_name']       = $options->get('first_name');
            $value['second_name']      = $options->get('second_name');
            $value['dependent_source'] = $options->get('dependent_source');
            $value['multiple']         = $options->get('multiple');

            return $value;
        });

        $resolver->setRequired(array('dependent_source'));

        $resolver->setAllowedValues(
            array(
                'widget' => array('choice'),
            ));

        $resolver->setAllowedTypes(
            array(
                'multiple'         => array('bool'),
                'choices'          => array('array'),
                'dependent_source' => array('string'),
            ));
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getBlockPrefix()
    {
        return 'thrace_select2_dependent';
    }
}