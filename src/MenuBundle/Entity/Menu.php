<?php

namespace MenuBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Menu
 *
 * @ORM\Entity(repositoryClass="MenuBundle\Entity\MenuRepository")
 * @ORM\Table(name="menu_menu")
 * @ORM\HasLifecycleCallbacks
 */
class Menu
{
    const TYPE_HEADER  = 0;
    const TYPE_FOOTER  = 1;

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
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=300, nullable=true)
     */
    protected $url;

    /**
     * @var bool
     *
     * @ORM\Column(type="smallint", columnDefinition="TINYINT(10) UNSIGNED DEFAULT 0 NOT NULL")
     */
    protected $type;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isActive;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isBlank;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    protected $itemClass;

    /**
     * @var int
     *
     * @Assert\GreaterThanOrEqual(0)
     *
     * @ORM\Column(type="integer", options={"default"=0}, nullable=false)
     */
    protected $orderNum;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @var \MenuBundle\Entity\Menu
     *
     * @ORM\ManyToOne(targetEntity="MenuBundle\Entity\Menu", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $parent;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MenuBundle\Entity\Menu", mappedBy="parent", fetch="EXTRA_LAZY")
     * @ORM\OrderBy({"orderNum" = "ASC"})
     */
    protected $children;

    /**
     * @var \PageBundle\Entity\Page
     *
     * @ORM\ManyToOne(targetEntity="PageBundle\Entity\Page")
     * @ORM\JoinColumn(name="page", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $page;

    /**
     * @var array
     */
    protected static $types = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orderNum     = 0;
        $this->isActive     = true;
        $this->type         = self::TYPE_HEADER;
        $this->createdAt    = new \DateTime('now');
        $this->children     = new ArrayCollection();
    }

    /**
     * "String" representation of class
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getTitle();
    }

    /**
     * @param int $type
     *
     * @return Menu
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public static function getTypeList()
    {
        return [
            self::TYPE_HEADER     => 'header',
            self::TYPE_FOOTER     => 'footer',
        ];
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set isActive
     *
     * @param bool $isActive
     *
     * @return Menu
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set isBlank
     *
     * @param bool $isBlank
     *
     * @return Menu
     */
    public function setIsBlank($isBlank)
    {
        $this->isBlank = $isBlank;

        return $this;
    }

    /**
     * Get isBlank
     *
     * @return bool
     */
    public function getIsBlank()
    {
        return $this->isBlank;
    }

    /**
     * Set itemClass
     *
     * @param string $itemClass
     *
     * @return Menu
     */
    public function setItemClass($itemClass)
    {
        $this->itemClass = $itemClass;

        return $this;
    }

    /**
     * Get itemClass
     *
     * @return string
     */
    public function getItemClass()
    {
        return $this->itemClass;
    }

    /**
     * Set orderNum
     *
     * @param int $orderNum
     *
     * @return Menu
     */
    public function setOrderNum($orderNum)
    {
        $this->orderNum = $orderNum;

        return $this;
    }

    /**
     * Get orderNum
     *
     * @return int
     */
    public function getOrderNum()
    {
        return $this->orderNum;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Menu
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set parent
     *
     * @param \MenuBundle\Entity\Menu $parent
     *
     * @return Menu
     */
    public function setParent(\MenuBundle\Entity\Menu $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \MenuBundle\Entity\Menu
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child.
     *
     * @param \MenuBundle\Entity\Menu $child
     *
     * @return Menu
     */
    public function addChild(\MenuBundle\Entity\Menu $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child.
     *
     * @param \MenuBundle\Entity\Menu $child
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeChild(\MenuBundle\Entity\Menu $child)
    {
        return $this->children->removeElement($child);
    }

    /**
     * Get children.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Has children.
     *
     * @return bool
     */
    public function hasChildren()
    {
        return count($this->children->getSnapshot()) > 0;
    }

    /**
     * Set page
     *
     * @param \PageBundle\Entity\Page $page
     *
     * @return Menu
     */
    public function setPage(\PageBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \PageBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }
}
