DateRangePicker
===============

This datepicker is a jQuery widget with two date range text fields.

See [demo](http://jqueryui.com/datepicker/#date-range)

### Usage with default options:

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('daterangepicker', 'thrace_daterangepicker', array(
            'label' => 'DateRangePicker',
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

**Note:** Each date field has the same options as datepicker. Use *options* to pass options to both fields or *first_option*, *second_option*.

**Note:** All configs are passed as json object to the widget.

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
        'bundles/thraceform/js/datepicker.js'
   
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

**Note:** Datepicker is locale aware. 

**Limitations:** The only available format is *Y-m-d*.

That's it.

[back to index](index.md#list)
