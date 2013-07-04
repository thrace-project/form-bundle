Slider
======

The slider is a jQuery widget.

See [demo](http://jqueryui.com/slider/)

### Usage:

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('slider', 'thrace_slider', array(
            'label' => 'Slider',
            'configs' => array(
            	'tpl' => 'Value: __value__',
                'step' => 5, 
                'min' => 35,
                'max' => 80,
            ),
        ))
		// .....
    ;
}
```

**Note:** __value__ is replaced by the current value of the slider.

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
        'bundles/thraceform/js/slider.js'
   
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

[jQuery API documentation](http://api.jqueryui.com/slider/)

That's it.

[back to index](index.md#list)
