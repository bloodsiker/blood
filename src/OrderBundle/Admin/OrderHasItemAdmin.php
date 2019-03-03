<?php

namespace OrderBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

/**
 * Class OrderHasItemAdmin
 */
class OrderHasItemAdmin extends Admin
{
    protected $parentAssociationMapping = 'server';

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('order', null, [
                'label' => 'order_has_item.fields.order',
            ])
            ->add('server', null, [
                'label' => 'order_has_item.fields.server',
            ])
            ->add('item', null, [
                'label' => 'order_has_item.fields.item',
            ])
            ->add('quantity', null, [
                'label' => 'order_has_item.fields.quantity',
            ])
            ->add('price', null, [
                'label' => 'order_has_item.fields.price',
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
            ->add('server', ModelListType::class, [
                'label' => 'order_has_item.fields.server',
                'required' => true,
                'btn_delete' => false,
                'btn_add' => false,
                'btn_edit' => false,
            ], ['link_parameters' => $linkParameters])
            ->add('item', ModelListType::class, [
                'label' => 'order_has_item.fields.item',
                'required' => true,
                'btn_delete' => false,
                'btn_add' => false,
                'btn_edit' => false,
            ], ['link_parameters' => $linkParameters])
            ->add('quantity', IntegerType::class, [
                'label' => 'order_has_item.fields.quantity',
                'required' => false,
            ])
            ->add('price', MoneyType::class, [
                'label' => 'order_has_item.fields.price',
                'currency' => 'usd',
                'required' => false,
                'attr' => [
                    'readonly' => true,
                ]
            ])
            ->add('discount', IntegerType::class, [
                'label' => 'order_has_item.fields.discount',
                'required' => false,
                'attr' => [
                    'readonly' => true,
                ]
            ])
        ;
    }
}
