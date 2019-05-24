<?php

namespace GameBundle\Twig;

use GameBundle\Entity\Game;
use GameBundle\Entity\Server;
use GameBundle\Helper\GameRouterHelper;
use ShareBundle\Entity\Category;

/**
 * Class GameExtension
 */
class GameExtension extends \Twig_Extension
{
    /**
     * @var GameRouterHelper
     */
    private $gameRouterHelper;

    /**
     * ArticleExtension constructor.
     *
     * @param GameRouterHelper $gameRouterHelper
     */
    public function __construct(GameRouterHelper $gameRouterHelper)
    {
        $this->gameRouterHelper = $gameRouterHelper;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'game_extension';
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('game_category_path', array($this, 'getCategoryPath')),
            new \Twig_SimpleFunction('game_server_path', array($this, 'getServerPath')),
        ];
    }

    /**
     * @param Game        $game
     * @param Category    $category
     * @param Server|null $server
     * @param bool        $needAbsolute
     *
     * @return string
     */
    public function getCategoryPath(Game $game, Category $category, Server $server = null, $needAbsolute = false) : string
    {
        return $this->gameRouterHelper->getCategoryPath($game, $category, $server, $needAbsolute);
    }

    /**
     * @param Game          $game
     * @param Server        $server
     * @param Category|null $category
     * @param bool          $needAbsolute
     *
     * @return string
     */
    public function getServerPath(Game $game, Server $server, Category $category = null, $needAbsolute = false) : string
    {
        return $this->gameRouterHelper->getServerPath($game, $server, $category, $needAbsolute);
    }
}
