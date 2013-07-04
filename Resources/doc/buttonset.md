Buttonset
==========

The buttonset is styled as toggle buttons. It could be multiple or single choice.
See [demo](http://jqueryui.com/button/#radio)

### Usage:

**Note:** You can replace *choice* with *entity* and etc.

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('buttonset', 'thrace_buttonset_choice', array(
	        'label' => 'Buttonset', 
	        'multiple' => false,
	        'choices' => array('value1' => 'label1', 'value2' => 'label2', 'value3' => 'label3'),
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
        'bundles/thraceform/js/buttonset.js'
   
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


