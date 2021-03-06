<?php

namespace DiscountBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class PackHasItemAdmin
 */
class PackHasItemAdmin extends Admin
{
    protected $parentAssociationMapping = 'pack';

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('product', null, [
                'label' => 'pack_has_item.fields.product',
            ])
            ->add('pack', null, [
                'label' => 'pack_has_item.fields.pack',
            ])
            ->add('isActive', null, [
                'label' => 'pack_has_item.fields.is_active',
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
            ->add('product', ModelListType::class, [
                'label' => 'pack_has_item.fields.product',
                'required' => true,
                'btn_delete' => false,
            ], ['link_parameters' => $linkParameters])
            ->add('isActive', null, [
                'label' => 'pack_has_item.fields.is_active',
                'required' => false,
            ])
            ->add('orderNum', HiddenType::class, [
                'label' => 'pack_has_item.fields.order_num',
            ])
        ;
    }
}
