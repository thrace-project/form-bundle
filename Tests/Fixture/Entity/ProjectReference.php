<?php
namespace Thrace\FormBundle\Tests\Fixture\Entity;

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