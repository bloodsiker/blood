<?php

namespace OrderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class OrderHasItem
 *
 * @ORM\Entity()
 * @ORM\Table(name="orders_has_items")
 * @ORM\HasLifecycleCallbacks
 */
class OrderHasItem
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
     * @var \OrderBundle\Entity\Order
     *
     * @ORM\ManyToOne(targetEntity="OrderBundle\Entity\Order", inversedBy="orderHasItems")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=false)
     */
    protected $order;

    /**
     * @var \ServerBundle\Entity\Server
     *
     * @ORM\ManyToOne(targetEntity="ServerBundle\Entity\Server")
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
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $quantity;

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
     * Constructor
     */
    public function __construct()
    {
        $this->orderNum = 0;
        $this->quantity = 1;
        $this->price = 0;
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
     * Set order.
     *
     * @param \OrderBundle\Entity\Order $order
     *
     * @return $this
     */
    public function setOrder(\OrderBundle\Entity\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order.
     *
     * @return \OrderBundle\Entity\Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set server
     *
     * @param \ServerBundle\Entity\Server $server
     *
     * @return $this
     */
    public function setServer(\ServerBundle\Entity\Server $server = null)
    {
        $this->server = $server;

        return $this;
    }

    /**
     * Get server
     *
     * @return \ServerBundle\Entity\Server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Set item
     *
     * @param \ShareBundle\Entity\Item
     *
     * @return $this
     */
    public function setItem(\ShareBundle\Entity\Item $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \ShareBundle\Entity\Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set quantity
     *
     * @param int $quantity
     *
     * @return $this
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;

        return $this;
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
}
