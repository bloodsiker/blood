<?php

namespace ProductBundle\Block;

use AppBundle\Services\Cart;
use Doctrine\ORM\EntityManager;
use GameBundle\Entity\Game;
use ProductBundle\Entity\Product;
use Sonata\BlockBundle\Meta\Metadata;
use Sonata\BlockBundle\Block\Service\AbstractAdminBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GameProductInMainBlockService
 */
class GameProductInMainBlockService extends AbstractAdminBlockService
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
            'template' => 'ProductBundle:Block:game_product_in_main.html.twig',
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

        $gameRepository = $this->entityManager->getRepository(Game::class);
        $productRepository = $this->entityManager->getRepository(Product::class);
        $gameInMain = $gameRepository->findBy(['isActive' => true, 'showInMain' => true], ['orderNum' => 'ASC']);
        $games = [];
        foreach ($gameInMain as $game) {
            $qb = $productRepository->baseProductQueryBuilder();
            $productRepository->filterByGame($qb, $game);
            $result = $qb
                ->addSelect('MIN(p.price) as min_price, MIN(p.discount) as min_discount')
                ->groupBy('p.item')
                ->setFirstResult(0)
                ->setMaxResults(5)
                ->getQuery()
                ->getResult();
            $games[$game->getId()]['game'] = $game;
            $games[$game->getId()]['products'] = $result;
        }

        return $this->renderResponse($blockContext->getTemplate(), [
            'games'      => $games,
            'settings'   => $blockContext->getSettings(),
            'block'      => $blockContext->getBlock(),
        ]);
    }
}
