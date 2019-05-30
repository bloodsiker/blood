<?php

namespace ProductBundle\Block;

use AppBundle\Services\Cart;
use Doctrine\ORM\EntityManager;
use GameBundle\Entity\Game;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use ProductBundle\Entity\Product;
use ShareBundle\Entity\Category;
use Sonata\BlockBundle\Meta\Metadata;
use Sonata\BlockBundle\Block\Service\AbstractAdminBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProductInMainBlockService
 */
class ProductInMainBlockService extends AbstractAdminBlockService
{
    const TEMPLATE_AJAX = 'ProductBundle:Block:ajax_load_product.html.twig';

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * CartBlockService constructor.
     *
     * @param string          $name
     * @param EngineInterface $templating
     * @param RequestStack    $requestStack
     * @param EntityManager   $entityManager
     */
    public function __construct($name, EngineInterface $templating, RequestStack $requestStack, EntityManager $entityManager)
    {
        parent::__construct($name, $templating);

        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    /**
     * @param null $code
     *
     * @return Metadata
     */
    public function getBlockMetadata($code = null)
    {
        return new Metadata(
            $this->getName(),
            (!is_null($code) ? $code : $this->getName()),
            false,
            'ProductBundle',
            ['class' => 'fa fa-th-large']
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'items_count' => 18,
            'page'        => 1,
            'game'        => null,
            'category'    => null,
            'template'    => 'ProductBundle:Block:product_in_main.html.twig',
        ]);
    }

    /**
     * @param BlockContextInterface $blockContext
     * @param Response|null $response
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        if (!$blockContext->getBlock()->getEnabled()) {
            return new Response();
        }

        $request = $this->requestStack->getCurrentRequest();

        $limit = (int) $blockContext->getSetting('items_count');
        $page = $request->get('page', 1) ?: $blockContext->getSetting('page');
        $first = $limit * ((int) $page - 1);

        $gameRepository = $this->entityManager->getRepository(Game::class);
        $productRepository = $this->entityManager->getRepository(Product::class);
        $categoryRepository = $this->entityManager->getRepository(Category::class);

        $qb = $productRepository->baseProductQueryBuilder();

        $game = $request->get('game') ?: $blockContext->getSetting('game');

        if ($game && $game !== 'all') {
            $game = is_object($game) ?: $gameRepository->find($game);
            $productRepository->filterByGame($qb, $game);
        }

        $category = $request->get('category') ?: $blockContext->getSetting('category');
        if ($category && $category !== 'all') {
            $category = is_object($category) ?: $categoryRepository->find($category);
            $productRepository->filterByCategory($qb, $category);
        }

        $result = $qb
            ->addSelect('MIN(p.price) as min_price, MIN(p.discount) as min_discount')
            ->groupBy('p.item')
            ->setFirstResult($first)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        $gameList = $gameRepository->findBy(['isActive' => true]);
        $categoryList = $categoryRepository->findAll();

        return $this->renderResponse($request->isXmlHttpRequest() ? self::TEMPLATE_AJAX : $blockContext->getTemplate(), [
            'products'     => $result,
            'gameList'     => $gameList,
            'categoryList' => $categoryList,
            'settings'     => $blockContext->getSettings(),
            'block'        => $blockContext->getBlock(),
        ]);
    }
}
