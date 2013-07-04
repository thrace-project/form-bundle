MultiSelect
===========

*MultiSelect* is based on jqgrid plugin with enabled *multiselect*  option. [see demo](http://trirand.com/blog/jqgrid/jqgrid.html).
It provides the following functionalities:

- search in big sets
- add/remove rows by checkboxes
- easy and transparent integration with Doctrine ORM

Imagine that you have *Category* and *Product* entities. You want to add some products to a category. The solution is *ThraceMultiSelect*.

### Usage. Let's create the *Category*

``` php
<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 */
class Category 
{
    /**
     * @var integer 
     *
     * @ORM\Id @ORM\Column(name="id", type="integer")
     * 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string 
     * 
     * @ORM\Column(type="string", name="title", length=255, nullable=true, unique=false)
     */
    protected $title;
    
    /**
     * @ORM\ManyToMany(targetEntity="Product", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinTable(
     *   inverseJoinColumns={@ORM\JoinColumn(unique=true,  onDelete="CASCADE")}
     * )
     */
    private $products;

    
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function getProducts()
    {
        return $this->products;
    }
    
    public function addProduct(Product $product)
    { 
        if (!$this->products->contains($product)){ 
            $this->products->add($product);
        }
    
        return $this;
    }
    
    
    public function removeProduct(Product $product)
    {
        if ($this->products->contains($product)){
            $this->products->removeElement($product);
        }
    
        return $this;
    }
    
}
```

As you see we have one-to-many unidirectional association with *Product* entity (It works with any type of associations).

##### Let's create the *Product*

``` php
<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Product
{
    /**
     * @var integer 
     *
     * @ORM\Id @ORM\Column(name="id", type="integer")
     * 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="name", length=255, nullable=true, unique=false)
     */
    protected $name;
    
    /**
     * @var decimal
     *
     * @ORM\Column(type="decimal", name="price", scale=2, precision=10)
     */
    protected $price;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
    public function getPrice()
    {
        return $this->price;
    } 
}
``` 
**Note:** Update your database running the following command:

``` bash
$ php app/console doctrine:schema:update --force
```

Model is ready. Let's create the datagrid. Make sure you have installed [ThraceDataGridBundle](https://github.com/thrace-project/datagrid-bundle)



``` php
<?php
namespace AppBundle\DataGrid;

use Doctrine\ORM\EntityManager;

use Symfony\Component\Translation\TranslatorInterface;

use Thrace\DataGridBundle\DataGrid\DataGridFactoryInterface;

class ProductBuilder
{
    const IDENTIFIER = 'product';
    
    protected $factory;
    
    protected $translator;
    
    protected $em;


    public function __construct (DataGridFactoryInterface $factory, TranslatorInterface $translator, EntityManager $em)
    {
        $this->factory = $factory;
        $this->translator = $translator;
        $this->em = $em;
    }

    public function build ()
    {
        
        $dataGrid = $this->factory->createDataGrid(self::IDENTIFIER);
        $dataGrid
            ->setCaption($this->translator->trans('caption'))
            ->setColNames(array(
                $this->translator->trans('column.name'), 
                $this->translator->trans('column.price'),  
            ))
            ->setColModel(array(
                array(
                    'name' => 'name', 'index' => 'p.name', 'width' => 200,
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 
                array(
                    'name' => 'price', 'index' => 'p.price', 'width' => 200,
                    'align' => 'left', 'sortable' => true, 'search' => true, 
                    'formatter' => 'currency'
                ),
            ))
            ->setQueryBuilder($this->getQueryBuilder())
            ->enableSearchButton(true)
            ->enablePager(true)
            ->enableViewRecords(true)
            ->enableMultiSelect(true)
        ;

        return $dataGrid;
    }


    protected function getQueryBuilder()
    {
        $qb = $this->em->getRepository('AppBundle:Product')->createQueryBuilder('p');
        $qb
            ->select('p.id, p.name, p.price, p')
        ;
        
        return $qb;
    }
}
```

You have to register the grid in service container [more info](https://github.com/thrace-project/datagrid-bundle/blob/master/Resources/doc/index.md#step-3-register-datagrid-in-the-service-container)

##### Let's build the form.

``` php
<?php
// ...
	protected $grid;
    
    public function setGrid(DataGridInterface $grid)
    {
        $this->grid = $grid;
    }
    
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('products', 'thrace_multi_select_collection', array(
            'label' => 'form.multi_select',
            'grid' => $this->grid,
            'options' => array(
            	'class' => 'AppBundle\Entity\Product'
            )
        )) 
		// .....
    ;
}
```
It's a standard symfony form.

##### Let's create the view.

``` jinja
	{% block stylesheets %}
                
		{% stylesheets
			'jquery/css/smoothness/jquery-ui.css' 
            'plugins/jqgrid/css/ui.jqgrid.css' 
            'bundles/thraceform/css/form_widgets.css'
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
		'plugins/jqgrid/js/i18n/grid.locale-en.js'
        'plugins/jqgrid/js/jquery.jqGrid.src.js'
        'bundles/thracedatagrid/js/init-datagrid.js'                                                                                                                                                                         
        'bundles/thraceform/js/multi-select.js'                                                                                                                                  
	%}
		<script src="{{ asset_url }}"></script>
	{% endjavascripts %}
   
{% endblock %}

{% form_theme form with ['ThraceFormBundle:Form:fields.html.twig'] %}
           
<form action="" method="post" {{ form_enctype(form) }} novalidate="novalidate">
    {{ form_errors(form) }}
	{{ form_widget(form) }}

    <input type="submit" />
</form>
```
**Note:** Update your assets running the following command:

``` bash
$ php app/console assetic:dump
```

Use standard symfony validators to validate the form.

That's it.

[back to index](index.md)