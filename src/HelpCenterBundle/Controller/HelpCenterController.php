<?php

namespace HelpCenterBundle\Controller;

use HelpCenterBundle\Entity\HelpArticle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

/**
 * Class HelpCenterController
 */
class HelpCenterController extends Controller
{
    const ARTICLE_404 = 'Article doesn\'t exist';

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Cache(maxage=60, public=true)
     */
    public function listAction(Request $request)
    {

        return $this->render('HelpCenterBundle::help_list.html.twig');
    }

    /**
     * @param int     $id
     * @param string  $slug
     * @param Request $request
     *
     * @return Response
     *
     * @Cache(maxage=60, public=true)
     */
    public function viewAction($id, $slug, Request $request)
    {
        $articleRepository = $this->getDoctrine()->getManager()->getRepository(HelpArticle::class);
        $article = $articleRepository->find((int) $id);
        if (!$article || !$article->getIsActive()) {
            throw $this->createNotFoundException(self::ARTICLE_404);
        }

        return $this->render('HelpCenterBundle::help_view.html.twig', [
            'article' => $article,
        ]);
    }
}