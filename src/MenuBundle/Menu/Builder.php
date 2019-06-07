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
//        $menu->setCurrent($currentUri);

        foreach ($items as $item) {
            if (!$item->getParent()) {
                $parent = $menu->addChild($item->title(), $this->getParams($item))
                    ->setExtra('itemClass', $item->getItemClass())
                ;

                $parent->setCurrent(
                    $this->checkCurrentMenu($parent->getUri(), $currentUri)
                );

            } else {
                $child = $menu[$item->getParent()->title()]->addChild(
                    $item->title($item),
                    $this->getParams($item)
                );

                $child->setCurrent($this->checkCurrentMenu($child->getUri(), $currentUri));
            }
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

            $uri = $item->getPage()->getUrl();
            $uri = str_replace('{page}', '', $uri);

            if (!$item->getGame()) {
                $params = ['uri' => $uri];
            } else {
                $params = [
                    'route' => $item->getPage()->getRouteName(),
                    'routeParameters' => [
                        'slug'  => $item->getGame()->getSlug(),
                    ],
                ];
            }

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

//        $pathParts = explode('/', trim($pathInfo, '/'));
//        $currentPage = reset($pathParts);

        return $pathInfo;
    }

    /**
     * @param string $menuUri
     * @param string $currentUri
     *
     * @return bool
     */
    private function checkCurrentMenu($menuUri, $currentUri)
    {
        $selected = ($menuUri === $currentUri);
        if (!$selected && $parts = explode('/', $currentUri)) {
            $subUri = implode('/', array_slice($parts, 0, -1));
            $selected = ($menuUri === $subUri);
        }

        return $selected;
    }
}