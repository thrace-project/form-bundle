SliderRange
===========

The SliderRange is a jQuery widget slider range element.

See [demo](http://jqueryui.com/slider/#range)

### Usage:

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('slider_range', 'thrace_slider_range', array(
            'label' => 'Slider range',
            'configs' => array(
                'tpl' => 'Min: __value_1__ Max: __value_2__',
                'step' => 5, 
                'min' => 35,
                'max' => 80,
            ),
        ))
		// .....
    ;
}
```

**Note:** __value_1__ and __value_2__ are replaced by the current value of the range slider.

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
        'bundles/thraceform/js/slider-range.js'
   
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


