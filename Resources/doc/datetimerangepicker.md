DateTimeRangePicker
===================

The DateTimeRangePicker is a jQuery widget with two datetime range text fields.

See [demo](http://trentrichardson.com/examples/timepicker/)

### Usage with default options:

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('datetimerangepicker', 'thrace_datetimerangepicker', array(
            'label' => 'DateTimeRangePicker',
            'options' => array(),
            'first_options'  => array(),
            'second_options' => array(),
            'first_name'     => 'first_date',
            'second_name'    => 'second_date',
        ))
		// .....
    ;
}
```

**Note:** Each datetime field has the same options as datetimepicker. Use *options* to pass options to both fields or *first_option*, *second_option*.

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

**Note:** DateTimeRangePicker is locale aware. 

**Limitations:** The only available format is *Y-m-d H:i:s* and *Y-m-d H:i*.

That's it.

[back to index](index.md#list)

