<?php

namespace ServerBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

/**
 * Class ServerHasItemAdmin
 */
class ServerHasItemAdmin extends Admin
{
    protected $parentAssociationMapping = 'server';

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('server', null, [
                'label' => 'server_has_item.fields.server',
            ])
            ->add('item', null, [
                'label' => 'server_has_item.fields.item',
            ])
            ->add('available', null, [
                'label' => 'server_has_item.fields.available',
            ])
            ->add('price', null, [
                'label' => 'server_has_item.fields.price',
            ])
            ->add('isHot', null, [
                'label' => 'server_has_item.fields.is_hot',
            ])
            ->add('isNew', null, [
                'label' => 'server_has_item.fields.is_new',
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
                'label' => 'server_has_item.fields.item',
                'required' => true,
                'btn_delete' => false,
            ], ['link_parameters' => $linkParameters])
            ->add('available', IntegerType::class, [
                'label' => 'server_has_item.fields.available',
                'required' => false,
            ])
            ->add('price', MoneyType::class, [
                'label' => 'server_has_item.fields.price',
                'currency' => 'usd',
                'required' => false,
            ])
            ->add('discount', IntegerType::class, [
                'label' => 'server_has_item.fields.discount',
                'required' => false,
            ])
            ->add('isHot', null, [
                'label' => 'server_has_item.fields.is_hot',
                'required' => false,
            ])
            ->add('isNew', null, [
                'label' => 'server_has_item.fields.is_new',
                'required' => false,
            ])
        ;
    }
}
