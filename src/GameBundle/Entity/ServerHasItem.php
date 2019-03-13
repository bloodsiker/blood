<?php

namespace GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ServerHasItem
 *
 * @ORM\Entity(repositoryClass="GameBundle\Entity\ServerHasItemRepository")
 * @ORM\Table(name="game_server_has_item")
 * @ORM\HasLifecycleCallbacks
 */
class ServerHasItem
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
     * @ORM\ManyToOne(targetEntity="GameBundle\Entity\Server", inversedBy="serverHasItems")
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
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, options={"default": 0})
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
    protected $isNew;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orderNum = 0;
        $this->price = 0;
        $this->available = 1;
        $this->discount = 0;
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
}
