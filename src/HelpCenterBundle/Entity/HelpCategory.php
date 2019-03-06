<?php

namespace HelpCenterBundle\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class HelpCategory
 *
 * @ORM\Entity()
 * @ORM\Table(name="help_category")
 * @ORM\HasLifecycleCallbacks
 */
class HelpCategory
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var \GameBundle\Entity\Game
     *
     * @ORM\ManyToOne(targetEntity="GameBundle\Entity\Game")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $game;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    protected $slug;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isActive;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="HelpCenterBundle\Entity\HelpArticle", mappedBy="category", fetch="EXTRA_LAZY")
     * @ORM\OrderBy({"id" = "ASC"})
     */
    protected $articles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->isActive = true;
    }

    /**
     * "String" representation of class
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        if (is_null($this->slug)) {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->getName());
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->prePersist();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $status
     *
     * @return $this
     */
    public function setName(string $status)
    {
        $this->name = $status;

        return $this;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return $this
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Get game
     *
     * @return \GameBundle\Entity\Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set game
     *
     * @param \GameBundle\Entity\Game|null $game
     *
     * @return $this
     */
    public function setGame(\GameBundle\Entity\Game $game = null)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Add article.
     *
     * @param \HelpCenterBundle\Entity\HelpArticle $articles
     *
     * @return $this
     */
    public function addArticle(\HelpCenterBundle\Entity\HelpArticle $articles)
    {
        $this->articles[] = $articles;

        return $this;
    }

    /**
     * Remove article.
     *
     * @param \HelpCenterBundle\Entity\HelpArticle $articles
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeArticle(\HelpCenterBundle\Entity\HelpArticle $articles)
    {
        return $this->articles->removeElement($articles);
    }

    /**
     * Get article.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }
}
