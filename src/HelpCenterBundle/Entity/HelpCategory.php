<?php

namespace HelpCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class HelpCategory
 *
 * @ORM\Entity()
 * @ORM\Table(name="help_category")
 * @ORM\HasLifecycleCallbacks
 */
class HelpCategory
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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var \GameBundle\Entity\Game
     *
     * @ORM\ManyToOne(targetEntity="GameBundle\Entity\Game")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $game;

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
        $this->isActive = true;
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $status
     *
     * @return $this
     */
    public function setName(string $status)
    {
        $this->name = $status;

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
     * Get game
     *
     * @return \GameBundle\Entity\Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set game
     *
     * @param \GameBundle\Entity\Game|null $game
     *
     * @return $this
     */
    public function setGame(\GameBundle\Entity\Game $game = null)
    {
        $this->game = $game;

        return $this;
    }
}
