<?php

namespace AppBundle\Block;

use AppBundle\Services\Cart;
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
    const TEMPLATE_BUTTON = 'AppBundle:cart:button.html.twig';
    const TEMPLATE_MODAL  = 'AppBundle:cart:modal.html.twig';

    const ACTION_ADD = 'add.cart';
    const ACTION_REMOVE = 'remove.cart';
    const ACTION_CLEAR = 'clear.cart';
    const ACTION_SHOW = 'show.cart';

    /**
     * @var RequestStack
     */
    private $request;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * CartBlockService constructor.
     *
     * @param string          $name
     * @param EngineInterface $templating
     * @param Cart            $cart
     * @param RequestStack    $request
     */
    public function __construct($name, EngineInterface $templating, Cart $cart, RequestStack $request)
    {
        parent::__construct($name, $templating);

        $this->cart = $cart;
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

        $request = $this->request->getCurrentRequest();

        $type = Cart::TYPE_PRODUCT;
        $action = self::ACTION_ADD;
        $id = 366;
        $count = 11;

        if ($request->isXmlHttpRequest()) {

            switch ($action) {
                case self::ACTION_ADD:
                    $this->addToCart($type, $id, $count);
                    break;
                case self::ACTION_REMOVE:
                    $this->removeProductFromCart($type, $id);
                    break;
                case self::ACTION_CLEAR:
                    $this->clearCart();
                    break;
                case self::ACTION_SHOW:
                    $products = $this->getProductInfoFromCart();
                    break;
                default:
                    throw new \Exception('Undefined action');
            }
        }

        return $this->renderResponse($request->isXmlHttpRequest() ? self::TEMPLATE_MODAL : $blockContext->getTemplate(), [
            'countItems' => $this->cart->countItems(),
            'products'   => $products ?? [],
            'settings'   => $blockContext->getSettings(),
            'block'      => $blockContext->getBlock(),
        ]);
    }

    /**
     * Add product to cart
     *
     * @param string $type
     * @param int    $id
     * @param int    $count
     *
     * @throws \Exception
     */
    private function addToCart($type, int $id, int $count)
    {
        switch ($type) {
            case Cart::TYPE_PRODUCT:
                $this->cart->addProductToCart(Cart::TYPE_PRODUCT, $id, $count);
                break;
            case Cart::TYPE_DISCOUNT:
                $this->cart->addProductToCart(Cart::TYPE_DISCOUNT, $id, $count);
                break;
            default:
                throw new \Exception('Undefined type product');
        }
    }

    private function getProductInfoFromCart()
    {
        return $this->cart->getProductsInfo();
    }

    /**
     * Remove product from cart
     *
     * @param string $type
     * @param int $id
     *
     * @return bool
     */
    private function removeProductFromCart($type, int $id)
    {
        $this->cart->deleteProduct($type, $id);

        return true;
    }

    /**
     * Clear cart
     *
     * @return bool
     */
    private function clearCart()
    {
        $this->cart->clear();

        return true;
    }
}
