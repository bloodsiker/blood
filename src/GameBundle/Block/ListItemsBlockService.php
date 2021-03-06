<?php

namespace GameBundle\Block;

use Doctrine\Bundle\DoctrineBundle\Registry;
use GameBundle\Entity\Server;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use ProductBundle\Entity\Product;
use Sonata\BlockBundle\Meta\Metadata;
use Sonata\BlockBundle\Block\Service\AbstractAdminBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ListItemsBlockService
 */
class ListItemsBlockService extends AbstractAdminBlockService
{
    const POPULAR_LIST = 'BookBundle:Block:popular_list.html.twig';
    const TOP_100_LIST = 'BookBundle:Block:top_100_list.html.twig';

    /**
     * @var Registry $doctrine
     */
    protected $doctrine;

    /**
     * ListGenreBlockService constructor.
     *
     * @param string          $name
     * @param EngineInterface $templating
     * @param Registry        $doctrine
     */
    public function __construct($name, EngineInterface $templating, Registry $doctrine)
    {
        parent::__construct($name, $templating);

        $this->doctrine = $doctrine;
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
            'GameBundle',
            ['class' => 'fa fa-th-large']
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'list_type'        => null,
            'items_count'      => 20,
            'page'             => 1,
            'game'             => null,
            'server'           => null,
            'category'         => null,
            'template'         => 'GameBundle:Block:items_list.html.twig',
        ]);
    }

    /**
     * @param BlockContextInterface $blockContext
     * @param Response|null         $response
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $block = $blockContext->getBlock();

        if (!$block->getEnabled()) {
            return new Response();
        }

        $limit = (int) $blockContext->getSetting('items_count');
        $page = (int) $blockContext->getSetting('page');

        $gameServers = [];
        $gameCategory = [];

        $repositoryProduct = $this->doctrine->getRepository(Product::class);
        $repositoryServer = $this->doctrine->getRepository(Server::class);

        $qb = $repositoryProduct->baseProductQueryBuilder();

        if ($blockContext->getSetting('game')) {
            $repositoryProduct->filterByGame($qb, $blockContext->getSetting('game'));
            $gameServers = $repositoryServer->findBy(['game' => $blockContext->getSetting('game'), 'isActive' => true]);
        }

        if ($blockContext->getSetting('server')) {
            $repositoryProduct->filterByServer($qb, $blockContext->getSetting('server'));
        }

        $resultCategory = $qb->getQuery()->getResult();
        foreach ($resultCategory as $product) {
            foreach ($product->getItem()->getCategories() as $category) {
                $gameCategory[$category->getId()] = $category;
            }
        }

        if ($blockContext->getSetting('category')) {
            $repositoryProduct->filterByCategory($qb, $blockContext->getSetting('category'));
        }

        $paginator = new Pagerfanta(new DoctrineORMAdapter($qb, true, false));
        $paginator->setAllowOutOfRangePages(true);
        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage($page);

        $template = !is_null($blockContext->getSetting('list_type'))
            ? $blockContext->getSetting('list_type') : $blockContext->getTemplate();

        return $this->renderResponse($template, [
            'game'         => $blockContext->getSetting('game'),
            'gameServers'  => $gameServers,
            'gameCategory' => $gameCategory,
            'products'     => $paginator,
            'block'        => $block,
            'settings'     => array_merge($blockContext->getSettings(), $block->getSettings()),
        ], $response);
    }
}
