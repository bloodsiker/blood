<?php

namespace DiscountBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Pack
 *
 * @ORM\Entity()
 * @ORM\Table(name="discount_pack")
 * @ORM\HasLifecycleCallbacks
 */
class Pack
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
    protected $discount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="DiscountBundle\Entity\PackHasItem",
     *     mappedBy="pack", cascade={"all"}, orphanRemoval=true
     * )
     * @ORM\OrderBy({"orderNum" = "ASC"})
     */
    protected $packHasItems;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->price = 0;
        $this->discount = 0;
        $this->createdAt = new \DateTime('now');

        $this->packHasItems   = new ArrayCollection();
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
     * Get discount
     *
     * @return int
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set discount
     *
     * @param int $discount
     *
     * @return $this
     */
    public function setDiscount(int $discount)
    {
        $this->discount = $discount;

        return $this;
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
     * Add packHasItems.
     *
     * @param \DiscountBundle\Entity\PackHasItem $packHasItems
     *
     * @return $this
     */
    public function addPackHasItem(\DiscountBundle\Entity\PackHasItem $packHasItems)
    {
        $packHasItems->setPack($this);
        $this->packHasItems[] = $packHasItems;

        return $this;
    }

    /**
     * Remove packHasItems.
     *
     * @param \DiscountBundle\Entity\PackHasItem $packHasItems
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePackHasItem(\DiscountBundle\Entity\PackHasItem $packHasItems)
    {
        return $this->packHasItems->removeElement($packHasItems);
    }

    /**
     * Get packHasItems.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPackHasItems()
    {
        return $this->packHasItems;
    }
}
