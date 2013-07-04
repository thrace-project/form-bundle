Recaptcha
=========

A ReCAPTCHA is a program that protects websites against bots by generating and grading tests that humans can pass but current computer programs cannot.

See [demo](http://www.google.com/recaptcha/learnmore)

**Important:** Before you start you need to configure it.

In you config.yml you need to put the following:

``` yaml
# app/config/config.yml

thrace_form:   
    recaptcha:
        public_key: your_public_key
        private_key: your_private_key

```
**Note:** Get your api keys from [here](https://www.google.com/recaptcha/admin/create)

### Usage:

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('recaptcha', 'thrace_recaptcha', array(
            'label' => 'Recaptcha',
            'constraints' => array(
                new \Thrace\FormBundle\Validator\Constraint\Recaptcha()   
            ),
            'configs' => array(
                'theme' => 'red',
            ),
        ))
		// .....
    ;
}
```

**Important:** You must add recaptcha constraint.

**Note:** All configs are passed as json object to the widget.

in the twig template add following code:

``` jinja

{% block javascripts %}

    {% javascripts
        'jquery/js/jquery.js'
        'http://www.google.com/recaptcha/api/js/recaptcha_ajax.js'
        'bundles/thraceform/js/recaptcha.js' 
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

[API documentation](https://developers.google.com/recaptcha/intro)

That's it.

[back to index](index.md#list)
