<?php

namespace DiscountBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

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
            ->add('item', null, [
                'label' => 'pack_has_item.fields.item',
            ])
            ->add('pack', null, [
                'label' => 'pack_has_item.fields.pack',
            ])
            ->add('isHot', null, [
                'label' => 'pack_has_item.fields.is_hot',
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
            ->add('item', ModelListType::class, [
                'label' => 'pack_has_item.fields.item',
                'required' => true,
                'btn_delete' => false,
            ], ['link_parameters' => $linkParameters])
            ->add('available', IntegerType::class, [
                'label' => 'pack_has_item.fields.available',
                'required' => false,
            ])
            ->add('price', MoneyType::class, [
                'label' => 'pack_has_item.fields.price',
                'currency' => 'usd',
                'required' => false,
            ])
            ->add('isHot', null, [
                'label' => 'pack_has_item.fields.is_hot',
                'required' => false,
            ])
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
