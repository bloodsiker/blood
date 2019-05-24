<?php

namespace GameBundle\Helper;

use GameBundle\Entity\Game;
use GameBundle\Entity\Server;
use ShareBundle\Entity\Category;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class GameRouterHelper
 */
class GameRouterHelper
{
    const GAME_SERVER_ROUTE = 'view_game_server';
    const GAME_CATEGORY_ROUTE = 'view_game_category';
    const GAME_SERVER_CATEGORY_ROUTE = 'view_game_server_category';

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * ArticleExtension constructor.
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param Game     $game
     * @param Category    $category
     * @param Server|null $server
     * @param bool  $needAbsolute
     *
     * @return string
     */
    public function getCategoryPath(Game $game, Category $category, Server $server = null, $needAbsolute = false) : string
    {
        if ($server) {
            $path = $this->router->generate(
                self::GAME_SERVER_CATEGORY_ROUTE,
                [
                    'slug' => $game->getSlug(),
                    'server' => $server->getSlug(),
                    'category' => $category->getSlug(),
                ],
                $needAbsolute ? UrlGeneratorInterface::ABSOLUTE_URL : UrlGeneratorInterface::ABSOLUTE_PATH
            );
        } else {
            $path = $this->router->generate(
                self::GAME_CATEGORY_ROUTE,
                [
                    'slug' => $game->getSlug(),
                    'category' => $category->getSlug(),
                ],
                $needAbsolute ? UrlGeneratorInterface::ABSOLUTE_URL : UrlGeneratorInterface::ABSOLUTE_PATH
            );
        }

        return $path;
    }

    /**
     * @param Game     $game
     * @param Server   $server
     * @param Category $category
     * @param bool  $needAbsolute
     *
     * @return string
     */
    public function getServerPath(Game $game, Server $server, Category $category = null, $needAbsolute = false) : string
    {
        if ($category) {
            $path = $this->router->generate(
                self::GAME_SERVER_CATEGORY_ROUTE,
                [
                    'slug' => $game->getSlug(),
                    'server' => $server->getSlug(),
                    'category' => $category->getSlug(),
                ],
                $needAbsolute ? UrlGeneratorInterface::ABSOLUTE_URL : UrlGeneratorInterface::ABSOLUTE_PATH
            );
        } else {
            $path = $this->router->generate(
                self::GAME_SERVER_ROUTE,
                [
                    'slug' => $game->getSlug(),
                    'server' => $server->getSlug(),
                ],
                $needAbsolute ? UrlGeneratorInterface::ABSOLUTE_URL : UrlGeneratorInterface::ABSOLUTE_PATH
            );
        }

        return $path;
    }
}
