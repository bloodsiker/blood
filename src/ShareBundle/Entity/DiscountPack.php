<?php

namespace ShareBundle\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class DiscountPack
 *
 * @ORM\Entity()
 * @ORM\Table(name="share_discount_pack")
 * @ORM\HasLifecycleCallbacks
 */
class DiscountPack
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
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ShareBundle\Entity\DiscountPackHasPack",
     *     mappedBy="discountPack", cascade={"all"}, orphanRemoval=true
     * )
     * @ORM\OrderBy({"orderNum" = "ASC"})
     */
    protected $discountPackHasPacks;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orderNum = 0;
        $this->createdAt = new \DateTime('now');

        $this->discountPackHasPacks   = new ArrayCollection();
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
    public function setGame(\MediaBundle\Entity\MediaImage $game = null)
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
     * Add discountPackHasPacks.
     *
     * @param \ShareBundle\Entity\DiscountPackHasPack $discountPackHasPacks
     *
     * @return $this
     */
    public function addDiscountPackHasPack(\ShareBundle\Entity\DiscountPackHasPack $discountPackHasPacks)
    {
        $discountPackHasPacks->setDiscountPack($this);
        $this->discountPackHasPacks[] = $discountPackHasPacks;

        return $this;
    }

    /**
     * Remove discountPackHasPacks.
     *
     * @param \ShareBundle\Entity\DiscountPackHasPack $discountPackHasPacks
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDiscountPackHasPack(\ShareBundle\Entity\DiscountPackHasPack $discountPackHasPacks)
    {
        return $this->discountPackHasPacks->removeElement($discountPackHasPacks);
    }

    /**
     * Get discountPackHasPacks.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDiscountPackHasPacks()
    {
        return $this->discountPackHasPacks;
    }
}
