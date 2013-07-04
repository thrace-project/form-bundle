Spinner
=======

Enhance a text input for entering numeric values, with up/down buttons and arrow key handling. 
See [demo](http://jqueryui.com/spinner/)

### Usage:

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('spinner', 'thrace_spinner', array(
            'label' => 'Spinner',
            'attr' => array(
                'readOnly' => true        
           ),
            'configs' => array(
                'min' => 0,
                'max' => 100,
                'step' => 5,
            ),
        ))
		// .....
    ;
}
```
**Note:** All configs are passed as json object to the widget.

In the twig template add following code:

``` jinja
{% block stylesheets %}
            
    {% stylesheets
       'jquery/css/smoothness/jquery-ui.css' 
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
        'bundles/thraceform/js/spinner.js'
   
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

[Complete API](http://api.jqueryui.com/spinner/)


That's it.

[back to index](index.md#list)
