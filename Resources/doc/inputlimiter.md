InputLimiter
============

The input limiter is a jQuery widget.

See [demo](http://rustyjeans.com/jquery-inputlimiter/demo.htm)

**Important:** download source from [here](http://code.google.com/p/jquery-inputlimiter/downloads/list)

### Usage:

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('inputlimiter', 'thrace_input_limiter', array(
            'label' => 'Limiter',
            'attr' => array(
                'class' => 'span5',      
                'rows' => 5        
            ),
            'configs' => array(
                'limit' => 255,
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
       'plugins/inputlimiter/jquery.inputlimiter.1.0.css'
       filter='cssrewrite'
    %}
        <link rel="stylesheet" href="{{ asset_url }}" />
    {% endstylesheets %}

{% endblock %}

{% block javascripts %}

    {% javascripts
        'jquery/js/jquery.js'
        'plugins/inputlimiter/jquery.inputlimiter.1.3.1.js'
        'bundles/thraceform/js/input-limiter.js'
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

[jQuery API documentation](http://rustyjeans.com/jquery-plugins/input-limiter#options)

**Note:** Widget translations are located in *Resources/translations/ThraceFormBundle.[lang].xlf*. 
Overwrite them by setting *translation_domain* in form type option.

That's it.

[back to index](index.md#list)
