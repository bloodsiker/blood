<?php

namespace AppBundle\Block;

use Sonata\BlockBundle\Meta\Metadata;
use Sonata\BlockBundle\Block\Service\AbstractAdminBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CartBlockService
 */
class CartBlockService extends AbstractAdminBlockService
{
    const SESSION_CART = 'user.cart';

    const TEMPLATE_BUTTON = 'AppBundle:cart:button.html.twig';
    const TEMPLATE_MODAL  = 'AppBundle:cart:modal.html.twig';

    /**
     * @var RequestStack
     */
    private $request;

    /**
     * CartBlockService constructor.
     *
     * @param string          $name
     * @param EngineInterface $templating
     * @param RequestStack    $request
     */
    public function __construct($name, EngineInterface $templating, RequestStack $request)
    {
        parent::__construct($name, $templating);

        $this->request  = $request;
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
            'AppBundle',
            ['class' => 'fa fa-th-large']
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'template' => self::TEMPLATE_BUTTON,
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
        if (!$blockContext->getBlock()->getEnabled()) {
            return new Response();
        }

        $request = $this->request->getCurrentRequest();
        $session = $request->getSession();

        if ($request->isXmlHttpRequest()) {

        }

        $session->set(self::SESSION_CART, ['id' => 34]);

        return $this->renderResponse($request->isXmlHttpRequest() ? self::TEMPLATE_MODAL : $blockContext->getTemplate(), [
            'settings'  => $blockContext->getSettings(),
            'block'     => $blockContext->getBlock(),
        ]);
    }
}
