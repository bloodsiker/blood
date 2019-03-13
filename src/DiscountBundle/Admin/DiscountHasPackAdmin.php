<?php

namespace DiscountBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * Class DiscountHasPackAdmin
 */
class DiscountHasPackAdmin extends Admin
{
    protected $parentAssociationMapping = 'discount';

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('discount', null, [
                'label' => 'discount_has_pack.fields.discount_pack',
            ])
            ->add('pack', null, [
                'label' => 'discount_has_pack.fields.pack',
            ])
            ->add('isActive', null, [
                'label' => 'discount_has_pack.fields.is_active',
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'delete' => [],
                ],
            ])
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $linkParameters = [];

        if ($this->hasParentFieldDescription()) {
            $linkParameters = $this->getParentFieldDescription()->getOption('link_parameters', []);
        }

        if ($this->hasRequest()) {
            $context = $this->getRequest()->get('context', null);

            if (null !== $context) {
                $linkParameters['context'] = $context;
            }
        }

        $formMapper
            ->add('pack', ModelListType::class, [
                'label' => 'discount_has_pack.fields.pack',
                'required' => true,
                'btn_delete' => false,
            ], ['link_parameters' => $linkParameters])
            ->add('isActive', null, [
                'label' => 'discount_has_pack.fields.is_active',
                'required' => false,
            ])
            ->add('orderNum', HiddenType::class, [
                'label' => 'discount_has_pack.fields.order_num',
            ])
        ;
    }
}
