<?php

namespace DiscountBundle\Block;

use DiscountBundle\Entity\Discount;
use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Meta\Metadata;
use Sonata\BlockBundle\Block\Service\AbstractAdminBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DiscountBlockService
 */
class DiscountBlockService extends AbstractAdminBlockService
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
            'DiscountBundle',
            ['class' => 'fa fa-th-large']
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'homepage' => false,
            'game'     => null,
            'template' => 'DiscountBundle:Block:discount_pack.html.twig',
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

        $discountRepository = $this->entityManager->getRepository(Discount::class);

        $discountList = [];

        $homepage = $blockContext->getSetting('homepage');
        if ($homepage) {
            $discountList = $discountRepository->findBy(['isActive' => true, 'isMain' => true]);
        }

        $game = $blockContext->getSetting('game');
        if ($game) {
            $discountList = $discountRepository->findBy(['isActive' => true, 'game' => $game]);
        }

        $list = [];
        foreach ($discountList as $discount) {
            $list[$discount->getId()]['discount'] = $discount;

            $discountHasPack = $discount->getDiscountHasPacks()->getValues();
            array_map(function ($key, $pack) use (&$discountHasPack) {
                if (!$pack->getIsActive()) {
                    unset($discountHasPack[$key]);
                }
            }, array_keys($discountHasPack), $discountHasPack);

            if (count($discountHasPack > 2)) {
                if ($discount->getIsRandom()) {
                    shuffle($discountHasPack);
                    $list[$discount->getId()]['packs'] = array_slice($discountHasPack, 0, 2);
                } else {
                    $list[$discount->getId()]['packs'] = array_slice($discountHasPack, 0, 2);
                }
            } else {
                $list[$discount->getId()]['packs'] = $discountHasPack;
            }
        }

        return $this->renderResponse($blockContext->getTemplate(), [
            'discountList' => $list,
            'settings'     => $blockContext->getSettings(),
            'block'        => $blockContext->getBlock(),
        ]);
    }
}
