Select2
=======

Select2 is a jQuery based replacement for select boxes. It supports searching, remote data sets, and infinite scrolling of results. 
See [demo](http://ivaynberg.github.com/select2/)

### Usage with *select* element:

Before you start download the source from [here] (https://github.com/ivaynberg/select2/tags) and put it somewhere in the *web folder*.

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('select2', 'thrace_select2_country', array(
            'label' => 'Select', 
            'multiple' => false,
            'empty_value' => 'Select option',
            'configs' => array(
                'width' => '300px',
            ),
        ))
		// .....
    ;
}
```

**Note:** You can replace *country* with *'choice', 'language', 'country', 'timezone', 'locale', 'entity', 'ajax'*. Ajax type will be explained later.

**Note:** *empty_value* option sets *placeholder* config of select2 widget. It is locale aware, no need to translate it. 

**Note:** when you set *multiple* option it also sets that option th the *select2 widget*.

**Important:** *configs* option is passed to *selec2 widget* as json object. It supports also javascript closures.

[Complete documentaton](http://ivaynberg.github.com/select2/)


### Usage with ajax

**Important:** There is one major problem with ajax *select2 widget*. Label has to be same as value. 
This is due to the fact that *select2 widget* uses text/hidden form element and stores only the values not the labels of the selected items.
This will be fixed as soon as posible.


``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('name', 'tharce_select2_ajax', array(
            'label' => 'Select', 
            'multiple' => false,
            'empty_value' => 'Select option',
            'configs' => array(
                'width' => '300px',
                'ajax' => array(
                    'url' => $this->container->get('router')->generate('ajax_route', array(), true),
                    'type' => 'GET',
                    'dataType' => 'json',  
                    'data' => "function (term, page) {
                        return {
                            q: term, //search term
                            page_limit: 5, // page size
                            page: page, // page number
                        };
                    }",
                    'results' => "function (data, page) { 
                        return {results: data};
                    }"      
                ),
            ),
        ))
		// .....
    ;
}
```

And the array structure:

``` php
$data = array(
    array('id' => 'value1', 'text' => 'value1'),
    array('id' => 'value2', 'text' => 'value2'),
    array('id' => 'value3', 'text' => 'value3'),
    array('id' => 'value4', 'text' => 'value4'),
    array('id' => 'value5', 'text' => 'value5'),
    array('id' => 'value6', 'text' => 'value6'),
    array('id' => 'value7', 'text' => 'value7'),
);
```

**Note:** *id* is equal to *text*

in the twig template add following code:

``` jinja
{% block stylesheets %}
            
    {% stylesheets
       'plugins/select2/select2.css'
        filter='cssrewrite'
    %}
        <link rel="stylesheet" href="{{ asset_url }}" />
    {% endstylesheets %}

{% endblock %}

{% block javascripts %}

    {% javascripts
        'jquery/js/jquery.js'
        'plugins/select2/select2.js'                    
        'bundles/thraceform/js/select2.js'
   
    %}
        <script src="{{ asset_url }}"></script>
	{% endjavascripts %}

{% endblock %}

{% form_theme form with ['ThraceFormBundle:Form:fields.html.twig'] %}

```
Run the following command:

``` bash
$ php app/console assetic:dump
```

That's it.

[back to index](index.md#list)
