Rating
======

The raty is a jQuery widget.

See [demo](http://wbotelhos.com/raty)

**Important:** download source from [here](https://github.com/wbotelhos/raty)

### Usage:

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('rating', 'thrace_rating', array(
            'label' => 'Rating',
            'configs' => array(
                'path' => 'plugins/raty/lib/img',
                'number' => 5,
            ),
        ))
		// .....
    ;
}
```

**Important:** Option *path* is required otherwise widget can not find its images!

**Note:** All configs are passed as json object to the widget.

In the twig template add following code:

``` jinja

{% block javascripts %}

    {% javascripts
        'jquery/js/jquery.js'
        'plugins/raty/lib/jquery.raty.js'
        'bundles/thraceform/js/rating.js'
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

[API documentation](http://wbotelhos.com/raty)

That's it.

[back to index](index.md#list)
