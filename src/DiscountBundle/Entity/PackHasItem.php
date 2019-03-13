<?php

namespace DiscountBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class PackHasItem
 *
 * @ORM\Entity()
 * @ORM\Table(name="discount_pack_has_item")
 * @ORM\HasLifecycleCallbacks
 */
class PackHasItem
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
     * @var \DiscountBundle\Entity\Pack
     *
     * @ORM\ManyToOne(targetEntity="DiscountBundle\Entity\Pack", inversedBy="packHasItems")
     * @ORM\JoinColumn(name="pack_id", referencedColumnName="id", nullable=false)
     */
    protected $pack;

    /**
     * @var \ShareBundle\Entity\Item
     *
     * @ORM\ManyToOne(targetEntity="ShareBundle\Entity\Item", fetch="EAGER")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id", nullable=false)
     */
    protected $item;

    /**
     * @var int
     *
     * @ORM\Column(name="order_num", type="integer", nullable=false, options={"default": 1})
     */
    protected $orderNum;

    /**
     * @var int
     *
     * @ORM\Column(type="float", nullable=false, options={"default": 0})
     */
    protected $price;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, options={"default": 0})
     */
    protected $available;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isHot;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isNew;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isActive;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orderNum = 0;
        $this->price = 0;
        $this->available = 1;
        $this->isActive = true;
    }

    /**
     * "String" representation of class
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->item;
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
     * Set pack.
     *
     * @param \DiscountBundle\Entity\Pack $pack
     *
     * @return $this
     */
    public function setPack(\DiscountBundle\Entity\Pack $pack = null)
    {
        $this->pack = $pack;

        return $this;
    }

    /**
     * Get pack.
     *
     * @return \DiscountBundle\Entity\Pack
     */
    public function getPack()
    {
        return $this->pack;
    }

    /**
     * Set item.
     *
     * @param \ShareBundle\Entity\Item $item
     *
     * @return $this
     */
    public function setItem(\ShareBundle\Entity\Item $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item.
     *
     * @return \ShareBundle\Entity\Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return $this
     */
    public function setPrice(float $price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get available
     *
     * @return int
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * Set available
     *
     * @param int $available
     *
     * @return $this
     */
    public function setAvailable(int $available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get isHot
     *
     * @return bool
     */
    public function getIsHot()
    {
        return $this->isHot;
    }

    /**
     * Set isHot
     *
     * @param bool $isHot
     *
     * @return $this
     */
    public function setIsHot(bool $isHot)
    {
        $this->isHot = $isHot;

        return $this;
    }

    /**
     * Get isNew
     *
     * @return bool
     */
    public function getIsNew()
    {
        return $this->isNew;
    }

    /**
     * Set isNew
     *
     * @param bool $isNew
     *
     * @return $this
     */
    public function setIsNew(bool $isNew)
    {
        $this->isNew = $isNew;

        return $this;
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
}
