<?php

namespace ProductBundle\Admin;

use AdminBundle\Admin\BaseAdmin as Admin;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class ProductAdmin
 */
class ProductAdmin extends Admin
{
    protected $datagridValues = [
        '_page'       => 1,
        '_per_page'   => 25,
        '_sort_by'    => 'id',
        '_sort_order' => 'DESC',
    ];

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, [
                'label' => 'product.fields.id',
            ])
            ->addIdentifier('image', null, [
                'label'     => 'product.fields.image',
                'template'  => 'ProductBundle:Admin:list_fields.html.twig',
            ])
            ->add('item', null, [
                'label' => 'product.fields.item',
            ])
            ->add('server', null, [
                'label' => 'product.fields.server',
            ])
            ->add('price', null, [
                'label'     => 'product.fields.price',
            ])
            ->add('discount', null, [
                'label'     => 'product.fields.discount',
            ])
            ->add('isHot', null, [
                'label'     => 'product.fields.is_hot',
                'editable'  => true
            ])
            ->add('isActive', null, [
                'label'     => 'product.fields.is_active',
                'editable'  => true
            ])
            ->add('createdAt', null, [
                'label' => 'product.fields.created_at',
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                ],
            ]);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('item', null, [
                'label' => 'product.fields.item',
            ])
            ->add('server', null, [
                'label' => 'product.fields.server',
            ])
            ->add('createdAt', null, [
                'label' => 'product.fields.created_at',
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form_group.basic', ['class' => 'col-md-8', 'name' => false])
                ->add('item', ModelListType::class, [
                    'label' => 'product.fields.item',
                    'required' => true,
                ])
                ->add('server', ModelListType::class, [
                    'label' => 'product.fields.server',
                    'required' => true,
                ])
            ->end()
            ->with('form_group.additional', ['class' => 'col-md-4', 'name' => false])
                ->add('isActive', null, [
                    'label' => 'product.fields.is_active',
                    'required' => false,
                ])
                ->add('isHot', null, [
                    'label' => 'product.fields.is_hot',
                    'required' => false,
                ])
                ->add('available', IntegerType::class, [
                    'label' => 'product.fields.available',
                    'required' => false,
                ])
                ->add('price', MoneyType::class, [
                    'label' => 'product.fields.price',
                    'currency' => 'usd',
                    'required' => false,
                ])
                ->add('discount', MoneyType::class, [
                    'label' => 'product.fields.discount',
                    'currency' => 'usd',
                    'required' => false,
                ])
                ->add('createdAt', DateTimePickerType::class, [
                    'label'     => 'product.fields.created_at',
                    'required' => true,
                    'format' => 'YYYY-MM-dd HH:mm',
                    'attr' => ['readonly' => true],
                ])
            ->end();
    }
}
