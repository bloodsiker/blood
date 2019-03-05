<?php

namespace GameBundle\Controller;

use GameBundle\Entity\Game;
use ShareBundle\Entity\ItemCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

/**
 * Class GameController
 */
class GameController extends Controller
{
    const GAME_404 = 'Game doesn\'t exist';
    const CATEGORY_404 = 'Category doesn\'t exist';

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Cache(maxage=60, public=true)
     */
    public function listAction(Request $request)
    {

        return $this->render('GameBundle::game_list.html.twig');
    }

    /**
     * @param string  $slug
     * @param string  $category
     * @param Request $request
     *
     * @return Response
     *
     * @Cache(maxage=60, public=true)
     */
    public function viewAction($slug, $category, Request $request)
    {
        $gameRepository = $this->getDoctrine()->getManager()->getRepository(Game::class);
        $game = $gameRepository->findOneBy(['slug' => (string) $slug]);
        if (!$game || !$game->getIsActive()) {
            throw $this->createNotFoundException(self::GAME_404);
        }

        if (!empty($categorySlug)) {
            $categorySlug = substr($category, 1);
            $categoryRepository = $this->getDoctrine()->getManager()->getRepository(ItemCategory::class);
            $categoryObject = $categoryRepository->findOneBy(['slug' => $categorySlug]);
            if (!$categoryObject) {
                throw $this->createNotFoundException(self::CATEGORY_404);
            }
        }

        return $this->render('GameBundle::game_view.html.twig', [
            'game'     => $game,
            'category' => $categoryObject ?? null,
        ]);
    }

    /**
     * @param string  $slug
     * @param string  $server
     * @param Request $request
     *
     * @return Response
     *
     * @Cache(maxage=60, public=true)
     */
    public function viewServerAction($slug, $server, Request $request)
    {
        $gameRepository = $this->getDoctrine()->getManager()->getRepository(Game::class);
        $game = $gameRepository->findOneBy(['slug' => (string) $slug]);
        if (!$game || !$game->getIsActive()) {
            throw $this->createNotFoundException(self::GAME_404);
        }

        return $this->render('GameBundle::game_view.html.twig', [
            'game'   => $game,
            'server' => $server,
        ]);
    }

    /**
     * @param string  $slug
     * @param string  $server
     * @param string  $category
     * @param Request $request
     *
     * @return Response
     *
     * @Cache(maxage=60, public=true)
     */
    public function viewServerCategoryAction($slug, $server, $category, Request $request)
    {
        $gameRepository = $this->getDoctrine()->getManager()->getRepository(Game::class);
        $game = $gameRepository->findOneBy(['slug' => (string) $slug]);
        if (!$game || !$game->getIsActive()) {
            throw $this->createNotFoundException(self::GAME_404);
        }

        return $this->render('GameBundle::game_view.html.twig', [
            'game'     => $game,
            'server'   => $server,
            'category' => $category,
        ]);
    }
}