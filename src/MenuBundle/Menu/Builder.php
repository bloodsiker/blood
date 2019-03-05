<?php

namespace MenuBundle\Menu;

use MenuBundle\Entity\Menu;
use Knp\Menu\FactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class Builder
 */
class Builder
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var RequestStack
     */
    private $request;

    /**
     * Builder constructor.
     *
     * @param FactoryInterface       $factory
     * @param RequestStack           $request
     * @param EntityManagerInterface $em
     */
    public function __construct(FactoryInterface $factory, RequestStack $request, EntityManagerInterface $em)
    {
        $this->em      = $em;
        $this->factory = $factory;
        $this->request = $request;
    }

    /**
     * @param RequestStack $requestStack
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function headerMenu(RequestStack $requestStack)
    {
        $items = $this->em
            ->getRepository('MenuBundle:Menu')
            ->getMenuItems(Menu::TYPE_HEADER);

        $currentUri = $this->getCurrentUri($requestStack);
        $menu = $this->factory->createItem('header');
        $menu->setCurrent($currentUri);

        foreach ($items as $item) {
            $menu->addChild($item->getTitle(), $this->getParams($item))
                ->setExtra('itemClass', $item->getItemClass())
            ;
        }

        return $menu;
    }

    /**
     * @param RequestStack $requestStack
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function footerMenu(RequestStack $requestStack)
    {
        $items = $this->em
            ->getRepository('MenuBundle:Menu')
            ->getMenuItems(Menu::TYPE_FOOTER);

        $menu = $this->factory->createItem('footer');

        foreach ($items as $item) {
             $menu->addChild($item->title(), $this->getParams($item))
                ->setExtra('itemClass', $item->getItemClass())
            ;
        }

        return $menu;
    }

    /**
     * @param Menu $item
     *
     * @return array
     */
    private function getParams(Menu $item)
    {
        if (!$item->getUrl() && ($item->getPage() && $item->getPage()->getId())) {
            $params = ['uri' => $item->getPage()->getUrl()];
        } else {
            $params = ['uri' => $item->getUrl()];
        }

        if ($item->getIsBlank()) {
            $params['linkAttributes'] = ['target' => '_blank'];
        }

        return $params;
    }

    /**
     * @param RequestStack $requestStack
     *
     * @return string
     */
    private function getCurrentUri(RequestStack $requestStack)
    {
        $request = $requestStack->getCurrentRequest();

        $pathInfo = strtr($request->getPathInfo(), [
            '/'.($request->getLocale() === 'uk' ? 'ua' : $request->getLocale()) => '',
        ]);

        $pathParts = explode('/', trim($pathInfo, '/'));
        $currentPage = reset($pathParts);

        return '/'.$currentPage;
    }
}