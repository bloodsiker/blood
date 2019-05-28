<?php

namespace ProductBundle\Controller;

use GameBundle\Entity\Game;
use GameBundle\Entity\Server;
use ShareBundle\Entity\Category;
use ShareBundle\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

/**
 * Class ProductController
 */
class ProductController extends Controller
{
    const PRODUCT_404 = 'Product doesn\'t exist';

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Cache(maxage=60, public=true)
     */
    public function listAction(Request $request)
    {

        return $this->render('ProductBundle::product_list.html.twig');
    }

    /**
     * @param string  $slug
     * @param Request $request
     *
     * @return Response
     *
     * @Cache(maxage=60, public=true)
     */
    public function viewAction($slug, Request $request)
    {
        $itemRepository = $this->getDoctrine()->getManager()->getRepository(Item::class);
        $item = $itemRepository->findOneBy(['slug' => (string) $slug]);
        if (!$item) {
            throw $this->createNotFoundException(self::PRODUCT_404);
        }

        return $this->render('ProductBundle::product_view.html.twig', [
            'item' => $item,
        ]);
    }
}