<?php

namespace DiscountBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class DiscountHasPack
 *
 * @ORM\Entity()
 * @ORM\Table(name="discount_discount_has_pack")
 * @ORM\HasLifecycleCallbacks
 */
class DiscountHasPack
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
     * @var \DiscountBundle\Entity\Discount
     *
     * @ORM\ManyToOne(targetEntity="DiscountBundle\Entity\Discount", inversedBy="discountHasPacks")
     * @ORM\JoinColumn(name="discount_id", referencedColumnName="id", nullable=false)
     */
    protected $discount;

    /**
     * @var \DiscountBundle\Entity\Pack
     *
     * @ORM\ManyToOne(targetEntity="DiscountBundle\Entity\Pack", fetch="EAGER")
     * @ORM\JoinColumn(name="pack_id", referencedColumnName="id", nullable=false)
     */
    protected $pack;

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
     * Constructor
     */
    public function __construct()
    {
        $this->orderNum = 0;
        $this->isActive = true;
    }

    /**
     * "String" representation of class
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->pack;
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
     * Set discount.
     *
     * @param \DiscountBundle\Entity\Discount $discount
     *
     * @return $this
     */
    public function setDiscountPack(\DiscountBundle\Entity\Discount $discount = null)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount.
     *
     * @return \DiscountBundle\Entity\Discount
     */
    public function getDiscountPack()
    {
        return $this->discount;
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
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set isActive
     *
     * @param bool $isActive
     *
     * @return $this
     */
    public function setIsActive(bool $isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }
}
