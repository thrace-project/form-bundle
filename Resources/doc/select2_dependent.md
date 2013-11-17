Select2 Dependent fields
========================

Select2 dependent fields is based on select2 jquery widget. 
It provides the abilility to have two fields where first is the master one and the second is dependent one.
When you select from the master dropdown then dependent dropdown is populated. Dependent field could be multiple as well.

**Limitations:** Only *choice type* is available for now.

### Usage:

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('select2_dependent', 'thrace_select2_dependent', array(
            'label' => 'Select two', 
            'choices' => array('value1' => 'label1', 'value2' => 'label2'),
            'multiple' => false,
            'dependent_source' => $this->container->get('router')->generate('ajax_route', array(), true),
            'first_options'  => array('horizontal_input_wrapper_class' => 'col-lg-4'), // with mopa bundle
             'second_options' => array('horizontal_input_wrapper_class' => 'col-lg-4'), // with mopa bundle
            'first_name' => 'first_name',
            'second_name' => 'second_name',
        ))
		// .....
    ;
}
```

You can set the options of each element by using *first_options* and *second_options*.

Controller should return json object with the following structure:

``` php
$data = array(
    array('id' => 'value1', 'text' => 'label1'),
    array('id' => 'value2', 'text' => 'label2'),
    array('id' => 'value3', 'text' => 'label3'),
);
```

[instalation and options information](select2.md)

That's it.

[back to index](index.md#list)
