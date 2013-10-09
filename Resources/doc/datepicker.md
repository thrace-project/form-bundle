Datepicker
===========

The datepicker is a jQuery widget.

See [demo](http://jqueryui.com/datepicker)

### Usage:

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('datepicker', 'thrace_datepicker', array(
            'label' => 'Datepicker',
            'input' => 'datetime', // [datetime, string, array, timestamp]
            'date_timezone' => null,
            'user_timezone' => null,
            'configs' => array(
                'maxDate' => '+10D'
            )
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
