<?php

namespace DiscountBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Discount
 *
 * @ORM\Entity()
 * @ORM\Table(name="discount_discount")
 * @ORM\HasLifecycleCallbacks
 */
class Discount
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
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    protected $name;

    /**
     * @var \MediaBundle\Entity\MediaImage
     *
     * @ORM\ManyToOne(targetEntity="MediaBundle\Entity\MediaImage")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $image;

    /**
     * @var \GameBundle\Entity\Game
     *
     * @ORM\ManyToOne(targetEntity="GameBundle\Entity\Game")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $game;

    /**
     * @var int
     *
     * @ORM\Column(name="order_num", type="integer", nullable=false, options={"default": 1})
     */
    protected $orderNum;

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
    protected $isMain;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isRandom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="DiscountBundle\Entity\DiscountHasPack",
     *     mappedBy="discount", cascade={"all"}, orphanRemoval=true
     * )
     * @ORM\OrderBy({"orderNum" = "ASC"})
     */
    protected $discountHasPacks;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orderNum = 0;
        $this->isActive = true;
        $this->createdAt = new \DateTime('now');

        $this->discountHasPacks   = new ArrayCollection();
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
     * Set image
     *
     * @param \MediaBundle\Entity\MediaImage $image
     *
     * @return $this
     */
    public function setImage(\MediaBundle\Entity\MediaImage $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \MediaBundle\Entity\MediaImage
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set game
     *
     * @param \GameBundle\Entity\Game $game
     *
     * @return $this
     */
    public function setGame(\GameBundle\Entity\Game $game = null)
    {
        $this->game = $game;

        return $this;
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
     * Set orderNum.
     *
     * @param int $orderNum
     *
     * @return $this
     */
    public function setOrderNum($orderNum)
    {
        $this->orderNum = $orderNum;

        return $this;
    }

    /**
     * Get orderNum.
     *
     * @return int
     */
    public function getOrderNum()
    {
        return $this->orderNum;
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
     * Set isMain
     *
     * @param boolean $isMain
     *
     * @return $this
     */
    public function setIsMain($isMain)
    {
        $this->isMain = $isMain;

        return $this;
    }

    /**
     * Get isMain
     *
     * @return boolean
     */
    public function getIsMain()
    {
        return $this->isMain;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return $this
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
     * Add discountHasPacks.
     *
     * @param \DiscountBundle\Entity\DiscountHasPack $discountPackHasPacks
     *
     * @return $this
     */
    public function addDiscountHasPack(\DiscountBundle\Entity\DiscountHasPack $discountPackHasPacks)
    {
        $discountPackHasPacks->setDiscountPack($this);
        $this->discountHasPacks[] = $discountPackHasPacks;

        return $this;
    }

    /**
     * Remove discountPackHasPacks.
     *
     * @param \DiscountBundle\Entity\DiscountHasPack $discountPackHasPacks
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDiscountHasPack(\DiscountBundle\Entity\DiscountHasPack $discountPackHasPacks)
    {
        return $this->discountHasPacks->removeElement($discountPackHasPacks);
    }

    /**
     * Get discountPackHasPacks.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDiscountHasPacks()
    {
        return $this->discountHasPacks;
    }

    /**
     * Get isRandom
     *
     * @return bool
     */
    public function getIsRandom()
    {
        return $this->isRandom;
    }

    /**
     * Set isRandom
     *
     * @param bool $isRandom
     *
     * @return $this
     */
    public function setIsRandom(bool $isRandom)
    {
        $this->isRandom = $isRandom;

        return $this;
    }
}
