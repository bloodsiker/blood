<?php

namespace MenuBundle\Controller;

use AdminBundle\Controller\CRUDController as Controller;

use Symfony\Bridge\Twig\AppVariable;
use Symfony\Bridge\Twig\Command\DebugCommand;
use Symfony\Bridge\Twig\Extension\FormExtension;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\FormView;

/**
 * Class MenuAdminController
 */
class MenuAdminController extends Controller
{
    /**
     * List action.
     *
     * @throws AccessDeniedException If access is not granted
     *
     * @return Response|RedirectResponse
     */
    public function listAction()
    {
        $this->admin->checkAccess('list');

        $type = $this->getRequest()->get('type', null);
        if (null === $type) {
            $types = $this->admin->getMenuTypes();
            $url = $this->admin->generateUrl('list', ['type' => reset($types)]);

            return new RedirectResponse($url);
        }

        return parent::listAction();
    }
}
