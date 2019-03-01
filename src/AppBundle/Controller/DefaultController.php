<?php

namespace AppBundle\Controller;

use BookBundle\Entity\Book;
use GenreBundle\Entity\Genre;
use SeriesBundle\Entity\Series;
use ShareBundle\Entity\Author;
use ShareBundle\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 */
class DefaultController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
//        $metaTitle = $this->get('translator')->trans('app.frontend.meta.meta_title_index', ['%YEAR%' => date("Y")], 'AppBundle');
//        $metaDescription = $this->get('translator')->trans('app.frontend.meta.meta_description_index', ['%YEAR%' => date("Y")], 'AppBundle');
//        $metaKeywords = $this->get('translator')->trans('app.frontend.meta.meta_keywords_index', ['%YEAR%' => date("Y")], 'AppBundle');

        $page = $request->get('page') ? " | Страница {$request->get('page', 1)}" : null;
        $pageDesc = $request->get('page') ? "Страница {$request->get('page', 1)} | " : null;

        $this->get('app.seo.updater')->doMagic(null, [
            'title' => 'TopBook.com.ua - скачать книги в fb2, epub, pdf, txt форматах'.$page,
            'description' => $pageDesc.'Электронная библиотека, скачать книги, читать рецензии, отзывы, книжные рейтинги.',
            'keywords' => 'скачать книги, рецензии, отзывы на книги, цитаты из книг, краткое содержание, топбук',
            'og' => [
                'og:url' => $request->getSchemeAndHttpHost(),
            ],
        ]);

        return new Response();
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function searchAction(Request $request)
    {
        $breadcrumb = $this->get('app.breadcrumb');
        $breadcrumb->addBreadcrumb(['title' => 'Поиск']);

        $this->get('app.seo.updater')->doMagic(null, [
            'title' => 'Поиск по каталогу книг | TopBook.com.ua - скачать книги в fb2, epub, pdf, txt форматах',
            'description' => 'Поиск по каталогу книг | ТопБук - электронная библиотека. Тут Вы можете скачать бесплатно книги',
            'keywords' => 'скачать книги, рецензии, отзывы на книги, цитаты из книг, краткое содержание, топбук',
        ]);

        return $this->render('AppBundle:search:search.html.twig');
    }
}
