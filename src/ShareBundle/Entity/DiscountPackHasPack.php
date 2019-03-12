<?php

namespace ShareBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class DiscountPackHasPack
 *
 * @ORM\Entity()
 * @ORM\Table(name="share_discount_pack_has_pack")
 * @ORM\HasLifecycleCallbacks
 */
class DiscountPackHasPack
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
     * @var \ShareBundle\Entity\DiscountPack
     *
     * @ORM\ManyToOne(targetEntity="ShareBundle\Entity\DiscountPack", inversedBy="discountPackHasItems")
     * @ORM\JoinColumn(name="discount_pack_id", referencedColumnName="id", nullable=false)
     */
    protected $discountPack;

    /**
     * @var \ShareBundle\Entity\Pack
     *
     * @ORM\ManyToOne(targetEntity="ShareBundle\Entity\Pack", fetch="EAGER")
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
     * Set discountPack.
     *
     * @param \ShareBundle\Entity\DiscountPack $discountPack
     *
     * @return $this
     */
    public function setDiscountPack(\ShareBundle\Entity\DiscountPack $discountPack = null)
    {
        $this->discountPack = $discountPack;

        return $this;
    }

    /**
     * Get discountPack.
     *
     * @return \ShareBundle\Entity\DiscountPack
     */
    public function getDiscountPack()
    {
        return $this->discountPack;
    }

    /**
     * Set pack.
     *
     * @param \ShareBundle\Entity\Pack $pack
     *
     * @return $this
     */
    public function setPack(\ShareBundle\Entity\Pack $pack = null)
    {
        $this->pack = $pack;

        return $this;
    }

    /**
     * Get pack.
     *
     * @return \ShareBundle\Entity\Pack
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
