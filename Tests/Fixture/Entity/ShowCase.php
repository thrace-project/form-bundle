<?php
namespace Thrace\FormBundle\Tests\Fixture\Entity;

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

        return $this;
    }


    public function removeProjectReference(ProjectReference $projectReference)
    {
        if ($this->projectReferences->contains($projectReference)){
            $this->projectReferences->removeElement($projectReference);
        }

        return $this;
    }
    
}