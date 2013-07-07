MultiSelectSortable
===================

Select2Sortable is based on [Select2 drag and drop sorting](http://ivaynberg.github.com/select2/). 

Imagine that you have a showcase page in your website and you want to add some projects to it.
But you have to be able not only to add projects but sort them. The solution is *MultiSelectSortable*.

### Usage:

Let's create the model. You will need three entities *ShowCase*, *ProjectReference* and *Project*.

##### Let's create *ShowCase* entity

``` php
<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ShowCase 
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
     * @ORM\OneToMany(targetEntity="ProjectReference", mappedBy="showCase", cascade={"all"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $projectReferences;
        
    public function __construct()
    {
        $this->projectReferences = new ArrayCollection();
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
    
    public function getProjectReferences()
    {
        return $this->projectReferences;
    }
    
    public function addProjectReference(ProjectReference $projectReference)
    { 
        if (!$this->projectReferences->contains($projectReference)){ 
            $this->projectReferences->add($projectReference);
            $projectReference->setShowCase($this);
        }
    }
    
    
    public function removeProjectReference(ProjectReference $projectReference)
    {
        if ($this->projectReferences->contains($projectReference)){
            $this->projectReferences->removeElement($projectReference);
        }
    }
}
```

As you see we have one-to-many bi-directional association with *ProjectReference* entity.

##### Let's create *ProjectReference* entity

``` php
<?php
namespace AppBundle\Entity;

use Thrace\FormBundle\Model\Select2SortableInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ProjectReference implements Select2SortableInterface
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
     * @var integer
     *
     * @ORM\Column(type="integer", name="position", length=10, nullable=false, unique=false)
     */
    protected $position = 0;
    
    /**
     * @ORM\ManyToOne(targetEntity="ShowCase", inversedBy="projectReferences")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $showCase;
    
    /**
     * @ORM\ManyToOne(targetEntity="Project", fetch="EAGER")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $project;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getLabel()
    {
        return $this->project->getTitle();
    }
    
    public function setPosition($position)
    {   
        $this->position = (int) $position;
    }
    
    public function getPosition()
    {
        return $this->position;
    }
    
    public function getShowCase ()
    {
        return $this->showCase;
    }
    
    public function setShowCase (ShowCase $showCase)
    {
        $this->showCase = $showCase;
    }
    
    public function getProject ()
    {
        return $this->project;
    }
    
    public function setProject (Project $project)
    {
        $this->project = $project;
    }
}
```

In *ProjectReference* we have many-to-one bi-directional association with *ShowCase* and many-to-one unidirectional association with *Project*.
You should implement *Select2SortableInterface*. 
*Select2SortableInterface::getLabel* is a proxy method and must return the label that will be shown on sortable element.

##### Let's create *Project* entity

``` php
<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 */
class Project 
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
    
}
```
**Note:** Update your database running the following command:

``` bash
$ php app/console doctrine:schema:update --force
```

##### Let's build the form.

``` php
<?php 
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        // .....
        ->add('projectReferences', 'thrace_select2_sortable', array(
            'label' => 'Select2Sortable',
            'reference_class' => 'AppBundle\Entity\ProjectReference',
            'inversed_class' => 'AppBundle\Entity\Project',
            'inversed_property' => 'project', // located in reference class
            'configs' => array(
                'tags' => $this->getTags(), // check get tags method!!!
                'width' => '400'
            ),
        ))
		// .....
    ;
}

// ...
    protected function getTags()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $repo = $em->getRepository('AppBundle:Project');
        
        $data = array();
        foreach ($repo->findAll() as $project){
            $data[] = array(
                'id' => $project->getId(),
                'text' => $project->getTitle()        
            );
        }
        
        return $data;
    }
```
It's a standard symfony form.

##### Let's create the view.

``` jinja
	{% block stylesheets %}
                
		{% stylesheets
			'plugins/select2/select2.css' 
            filter='cssrewrite'
        %}
            <link rel="stylesheet" href="{{ asset_url }}" />
        {% endstylesheets %}

    {% endblock %}
    
{% block javascripts %}

	{% javascripts
        'jquery/js/jquery.js'
        'jquery/js/jquery-ui.js'      
        'plugins/select2/select2.js'                                                                                                                                                                   
        'bundles/thraceform/js/select2-sortable.js'                                                                                                                                  
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

We're done. All you need is to drag and drop rows inside the sortable container. The rest is done by the bundle.

[back to index](index.md)