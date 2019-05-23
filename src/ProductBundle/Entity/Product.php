<?php

namespace ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 *
 * @ORM\Entity(repositoryClass="ProductBundle\Entity\ProductRepository")
 * @ORM\Table(name="product_product")
 * @ORM\HasLifecycleCallbacks
 */
class Product
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
     * @var \GameBundle\Entity\Server
     *
     * @ORM\ManyToOne(targetEntity="GameBundle\Entity\Server")
     * @ORM\JoinColumn(name="server_id", referencedColumnName="id", nullable=false)
     */
    protected $server;

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
     * @var int
     *
     * @ORM\Column(type="float", nullable=true)
     */
    protected $discount;

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
    protected $isActive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->price = 0;
        $this->isActive = true;
        $this->available = 1;

        $this->createdAt  = new \DateTime('now');
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
     * Set book.
     *
     * @param \GameBundle\Entity\Server $server
     *
     * @return $this
     */
    public function setServer(\GameBundle\Entity\Server $server = null)
    {
        $this->server = $server;

        return $this;
    }

    /**
     * Get server.
     *
     * @return \GameBundle\Entity\Server
     */
    public function getServer()
    {
        return $this->server;
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
     * @param float|null $discount
     *
     * @return $this
     */
    public function setDiscount(float $discount = null)
    {
        $this->discount = $discount;

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
}
