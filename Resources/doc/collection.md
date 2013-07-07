Collection
==========

The collection type prototypes the whole sub form.

**Note:** Example shows how to use with *MopaBootstrapBundle*

### Usage:

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        $builder
            ->add('collection', 'thrace_collection', array(
                'label' => 'form.collection',
                'type' => 'some_form_type',
                'options' => array( 
                    'label_render' => false,
                    'widget_control_group' => false,
                ),
                'configs' => array(
                	'empty_text' => 'collection.empty',      
                    'empty_text_class' => 'well',     
                    'add_button_text' => 'button.add',       
                    'add_button_class' => 'btn btn-primary',  
                    'remove_button_text' => 'button.remove',          
                    'remove_button_class' => 'btn btn-danger',     
                )
            ))        
        ;
		// .....
    ;
}
```

In the twig template add following code:

``` jinja
{% block javascripts %}

    {% javascripts
        'jquery/js/jquery.js'
        'jquery/js/jquery-ui.js'
        'bundles/thraceform/js/collection.js' 
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

**Notice** There are two jQuery event *thrace_form.collection.onAdd* and *thrace_form.collection.onRemove* attached to form collection type.
If you have some javascript type which are build onCreate then these events can be very helpful.

That's it.

[back to index](index.md#list)


