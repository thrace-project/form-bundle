DateTimePicker
==============

The DateTimePicker is an add-on to jQuery datepicker widget. 

See [demo](http://trentrichardson.com/examples/timepicker/)

### Usage:

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('datetimepicker', 'thrace_datetimepicker', array(
            'label' => 'DateTimePicker',
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

n the twig template add following code:

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
		'bundles/thraceform/js/datetimepicker.js'
   
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

[jQuery API documentation](http://api.jqueryui.com/datepicker/)

[Add-on API documentation](http://trentrichardson.com/examples/timepicker/)

**Limitations:** The only available format is *Y-m-d H:i:s* or *Y-m-d H:i*.

That's it.

[back to index](index.md#list)
