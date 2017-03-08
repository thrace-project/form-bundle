Using ThraceFormBundle
===========================
<a name="top"></a>
ThraceFormBundle adds supports for building RIA form elements without writing a single line of javascript code!

<a name="installation"></a>

## Installation

### Step 1) Get the bundle

First, grab the  ThraceFormBundle using composer (symfony 2.1 pattern)

Add on composer.json (see http://getcomposer.org/)

    "require" :  {
        // ...
        "thrace/form-bundle":"dev-master",
    }

### Step 2) Register the bundle

To start using the bundle, register it in your Kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Thrace\FormBundle\ThraceFormBundle(),
        // if you use form types which require thrace/datagrid-bundle
        new Thrace\DataGridBundle\ThraceDataGridBundle(),
    );
    // ...
}
```
### Step 3) Download jQuery, jQueryUI 

You need to download latest version of [jQuery](http://jquery.com/), [jqueryui](http://jqueryui.com/) 
then put the sources somewhere in the web folder. EX: *web/jquery*

**Note:** Each form element requires its own javascript library.

<a name="list"></a>
**List of all form elements**

* [Autocomplete](autocomplete.md)
* [Buttonset](buttonset.md)
* [Toggle button](toggle_button.md)
* [Slider](slider.md)
* [Slider Range](slider_range.md)
* [Spinner](spinner.md)
* [Datepicker](datepicker.md)
* [DateRangePicker](daterangepicker.md)
* [DateTimePicker](datetimepicker.md)
* [DateTimeRangePicker](datetimerangepicker.md)
* [Timepicker](timepicker.md)
* [ColorPicker](colorpicker.md)
* [InputLimiter](inputlimiter.md)
* [Rating](rating.md)
* [Recaptcha](recaptcha.md)
* [Select2](select2.md)
* [Select2 dependent](select2_dependent.md)
* [Select2 sortable](select2_sortable.md)
* [Tinymce](tinymce.md)
* [MultiSelectSortable](multi_select_sortable.md)
* [MultiSelect](multi_select.md)
* [Collection](collection.md)

[back to top](#top)