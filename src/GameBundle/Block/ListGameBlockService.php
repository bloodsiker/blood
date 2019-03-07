<?php

namespace GameBundle\Block;

use Doctrine\Bundle\DoctrineBundle\Registry;
use GameBundle\Entity\Game;
use GameBundle\Entity\Server;
use GameBundle\Entity\ServerHasItem;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Sonata\BlockBundle\Meta\Metadata;
use Sonata\BlockBundle\Block\Service\AbstractAdminBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ListGameBlockService
 */
class ListGameBlockService extends AbstractAdminBlockService
{
    const HOMEPAGE_LIST = 'GameBundle:Block:games_homepage_list.html.twig';

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
            'is_hot'           => false,
            'template'         => 'GameBundle:Block:games_list.html.twig',
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

        $repository = $this->doctrine->getRepository(Game::class);

        $qb = $repository->baseGameQueryBuilder();

        if ($blockContext->getSetting('is_hot')) {
            $repository->filterByHot($qb);
        }
        $games = $qb->getQuery()->getResult();

        $template = !is_null($blockContext->getSetting('list_type'))
            ? $blockContext->getSetting('list_type') : $blockContext->getTemplate();

        return $this->renderResponse($template, [
            'games'     => $games,
            'block'     => $block,
            'settings'  => array_merge($blockContext->getSettings(), $block->getSettings()),
        ], $response);
    }
}
