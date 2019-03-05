<?php

namespace OrderBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Order
 *
 * @ORM\Entity(repositoryClass="OrderBundle\Entity\OrderRepository")
 * @ORM\Table(name="orders")
 * @ORM\HasLifecycleCallbacks
 */
class Order
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
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $clientEmail;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $gameNickName;

    /**
     * @var \OrderBundle\Entity\OrderStatus
     *
     * @ORM\ManyToOne(targetEntity="OrderBundle\Entity\OrderStatus")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="OrderBundle\Entity\OrderHasItem",
     *     mappedBy="server", cascade={"all"}, orphanRemoval=true
     * )
     * @ORM\OrderBy({"orderNum" = "ASC"})
     */
    protected $orderHasItems;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime('now');

        $this->orderHasItems   = new ArrayCollection();
    }

    /**
     * "String" representation of class
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->gameNickName;
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
     * Get status
     *
     * @return \OrderBundle\Entity\OrderStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param \OrderBundle\Entity\OrderStatus $status
     *
     * @return $this
     */
    public function setStatus(\OrderBundle\Entity\OrderStatus $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get clientEmail
     *
     * @return string
     */
    public function getClientEmail()
    {
        return $this->clientEmail;
    }

    /**
     * Set clientEmail
     *
     * @param string $clientEmail
     *
     * @return $this
     */
    public function setClientEmail(string $clientEmail)
    {
        $this->clientEmail = $clientEmail;

        return $this;
    }

    /**
     * Get gameNickName
     *
     * @return string
     */
    public function getGameNickName()
    {
        return $this->gameNickName;
    }

    /**
     * Set gameNickName
     *
     * @param string $gameNickName
     *
     * @return $this
     */
    public function setGameNickName(string $gameNickName)
    {
        $this->gameNickName = $gameNickName;

        return $this;
    }

    /**
     * Add orderHasItems.
     *
     * @param \OrderBundle\Entity\OrderHasItem $orderHasItems
     *
     * @return $this
     */
    public function addOrderHasItem(\OrderBundle\Entity\OrderHasItem $orderHasItems)
    {
        $orderHasItems->setOrder($this);
        $this->orderHasItems[] = $orderHasItems;

        return $this;
    }

    /**
     * Remove orderHasItems.
     *
     * @param \OrderBundle\Entity\OrderHasItem $serverHasItems
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeOrderHasItem(\OrderBundle\Entity\OrderHasItem $serverHasItems)
    {
        return $this->orderHasItems->removeElement($serverHasItems);
    }

    /**
     * Get orderHasItems.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderHasItems()
    {
        return $this->orderHasItems;
    }
}
