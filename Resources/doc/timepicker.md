Timepicker
==========

The timepicker is a jQuery widget.

See [demo](http://trentrichardson.com/examples/timepicker/)

### Usage:

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('timepicker', 'thrace_timepicker', array(
            'label' => 'Timepicker',
            'with_seconds' => false,
            'use_meridiem' => false,
            'input' => 'datetime',
            'date_timezone' => null,
            'user_timezone' => null,
            'configs' => array()
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
        'plugins/timepicker/jquery-ui-timepicker-addon.css'
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
		'plugins/timepicker/jquery-ui-timepicker-addon.js'
		'plugins/timepicker/jquery-ui-sliderAccess.js'
		'bundles/thraceform/js/timepicker.js'           
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

[jQuery API documentation](http://trentrichardson.com/examples/timepicker/)

**Note:** Timepicker is locale aware. 


**Limitations:** The only available format is *H:i:s* and *H:i*.

That's it.

[back to index](index.md#list)


