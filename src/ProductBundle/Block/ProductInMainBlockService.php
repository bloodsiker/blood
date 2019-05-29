<?php

namespace ProductBundle\Block;

use AppBundle\Services\Cart;
use Doctrine\ORM\EntityManager;
use GameBundle\Entity\Game;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use ProductBundle\Entity\Product;
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
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * CartBlockService constructor.
     *
     * @param string          $name
     * @param EngineInterface $templating
     * @param EntityManager   $entityManager
     */
    public function __construct($name, EngineInterface $templating, EntityManager $entityManager)
    {
        parent::__construct($name, $templating);

        $this->entityManager = $entityManager;
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

        $limit = (int) $blockContext->getSetting('items_count');
        $page = (int) $blockContext->getSetting('page');

        $gameRepository = $this->entityManager->getRepository(Game::class);
        $productRepository = $this->entityManager->getRepository(Product::class);

        $qb = $productRepository->baseProductQueryBuilder();

        if ($blockContext->getSetting('game')) {
            $productRepository->filterByGame($qb, $blockContext->getSetting('game'));
        }

        if ($blockContext->getSetting('category')) {
            $productRepository->filterByCategory($qb, $blockContext->getSetting('category'));
        }

        $result = $qb->addSelect('MIN(p.price) as min_price, MIN(p.discount) as min_discount')
            ->groupBy('p.item')
            ->setFirstResult(0)
            ->setMaxResults(18)
            ->getQuery()
            ->getResult();

        return $this->renderResponse($blockContext->getTemplate(), [
            'products'   => $result,
            'settings'   => $blockContext->getSettings(),
            'block'      => $blockContext->getBlock(),
        ]);
    }
}
