Toggle button
=============

The toogle button is a jQuery widget.

See [demo](http://jqueryui.com/button/#checkbox)

### Usage:

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('toogle_button', 'thrace_toggle_button', array(
            'configs' => array(
                'checked_label' => 'checked',
                'unchecked_label' => 'unchecked',
                'icons' => array('primary' => 'ui-icon-check'),
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
        'bundles/thraceform/js/toggle-button.js'
   
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

That's it.

[back to index](index.md#list)


