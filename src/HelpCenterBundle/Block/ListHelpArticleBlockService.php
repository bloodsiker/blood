<?php

namespace HelpCenterBundle\Block;

use Doctrine\Bundle\DoctrineBundle\Registry;
use HelpCenterBundle\Entity\HelpCategory;
use HelpCenterBundle\Entity\HelpCenterRepository;
use Sonata\BlockBundle\Meta\Metadata;
use Sonata\BlockBundle\Block\Service\AbstractAdminBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ListHelpArticleBlockService
 */
class ListHelpArticleBlockService extends AbstractAdminBlockService
{
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
            'HelpCenterBundle',
            ['class' => 'fa fa-code']
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'game'     => null,
            'template' => 'HelpCenterBundle:Block:help_list.html.twig',
        ]);
    }

    /**
     * @param BlockContextInterface $blockContext
     * @param Response|null         $response
     *
     * @return Response
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $block = $blockContext->getBlock();

        if (!$block->getEnabled()) {
            return new Response();
        }

        $categoryRepository = $this->doctrine->getRepository(HelpCategory::class);
        $game = $blockContext->getSetting('game');

        $categories = $categoryRepository->findBy(['game' => $game]);


        return $this->renderResponse($blockContext->getTemplate(), [
            'categories' => $categories,
            'block'      => $block,
            'settings'   => array_merge($blockContext->getSettings(), $block->getSettings()),
        ], $response);
    }
}
