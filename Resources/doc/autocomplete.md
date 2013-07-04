Autocomplete 
============

The Autocomplete widget provides suggestions while you type into the field. See [demo](http://jqueryui.com/autocomplete/)

### Usage:
In the source option you must provide url which will return json object. The array source must have the following structure:

```  php
$data = array('label1' => 'value1', 'label2' => 'value2', 'label3' => 'value3');
```

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('country', 'thrace_autocomplete', array(
        	'label' => 'jQuery autocomplete',
        	'configs' => array(
        		'source' => $this->router->generate('ajax_route', array(), true),
        	),
        ))
		// .....
    ;
}
```

To use autocompleter with categories add *use_categories* option:

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('country', 'thrace_autocomplete', array(
        	'label' => 'jQuery autocomplete',
        	'configs' => array(
        		'source' => $this->router->generate('ajax_route', array(), true),
        		'use_categories' => true,
        	),
        ))
		// .....
    ;
}
```

And the array structure:

``` php
$data = array(
    array('label' => 'label1', 'value' => 'value1', 'category' => 'cat1'),
    array('label' => 'label2', 'value' => 'value2', 'category' => 'cat2'),
    array('label' => 'label3', 'value' => 'value3', 'category' => 'cat2'),
);
```

In *AjaxController* you get parameter *term* which will help you to build the query.

In the twig template add following code:

``` jinja
{% block stylesheets %}
            
    {% stylesheets
       'jquery/css/smoothness/jquery-ui.css' 
       'bundles/thraceform/css/form_widgets.css'
       filter='cssrewrite'
    %}
        <link rel="stylesheet" href="{{ asset_url }}" />
    {% endstylesheets %}

{% endblock %}

{% block javascripts %}

    {% javascripts
        'jquery/js/jquery.js'
        'jquery/js/jquery-ui.js'
        'jquery/i18n/jquery-ui-i18n.js'
        'bundles/thraceform/js/autocomplete.js'
   
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

**Note:** All configs are passed as json object to jQuery autocomplete widget.

[Complete api](http://api.jqueryui.com/autocomplete/)

That's it.

[back to index](index.md#list)

