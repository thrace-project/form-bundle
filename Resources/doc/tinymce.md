Tinymce
=======

TinyMCE has the ability to convert HTML TEXTAREA fields or other HTML elements to editor instances. 

See [demo](http://www.tinymce.com/tryit/full.php)

### Let's grab the source

[download from here](http://www.tinymce.com/download/download.php)

**Important:** Download version 4+.

Put the download folder *tinymce* in web root under */plugins*.

If you need more languages you can download them from [here](http://www.tinymce.com/i18n/index.php?ctrl=lang&act=download)

In you config.yml you need to put the following:

``` yaml
# app/config/config.yml

thrace_form:   
    tinymce:
        tiny_mce_base_path: "plugins/tinymce/js/tinymce" # check your path!!!

```

Let's create our first tinymce editor.

### Usage:

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('tinymce', 'thrace_tinymce', array(
            'label' => 'Content',
            'configs' => array(
                'width' => '100%',
                'height' => 400,
                'readonly' => false,
            ),
        ))
		// .....
    ;
}
```

in the twig template add following code:

``` jinja

{% block javascripts %}

    {% javascripts
        'jquery/js/jquery.js'
        'plugins/tinymce/js/tinymce/tinymce.min.js'                    
        'bundles/thraceform/js/tinymce.js'
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

[API documentation](http://www.tinymce.com/wiki.php)

**Note:** All configs are passed as json object to the widget.

That's it.

[back to index](index.md#list)