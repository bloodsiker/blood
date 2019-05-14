<?php

namespace ShareBundle\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Category
 *
 * @ORM\Entity
 * @ORM\Table(name="share_category")
 * @ORM\HasLifecycleCallbacks
 */
class Category
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
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    protected $slug;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ShareBundle\Entity\Item", mappedBy="categories")
     */
    protected $items;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * "String" representation of class
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName();
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Add item
     *
     * @param \ShareBundle\Entity\Item $item
     *
     * @return $this
     */
    public function addItem(\ShareBundle\Entity\Item $item)
    {
        $this->items[] = $item;
        return $this;
    }
    /**
     * Remove item
     *
     * @param \ShareBundle\Entity\Item $book
     */
    public function removeItem(\ShareBundle\Entity\Item $item)
    {
        $this->items->removeElement($item);
    }
    /**
     * Get book
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }
}
