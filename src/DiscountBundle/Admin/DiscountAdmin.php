<?php

namespace DiscountBundle\Admin;

use AdminBundle\Admin\BaseAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * Class DiscountAdmin
 */
class DiscountAdmin extends Admin
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
                'label' => 'discount.fields.id',
            ])
            ->add('image', null, [
                'label'     => 'discount.fields.image',
                'template'  => 'ShareBundle:Admin:list_fields.html.twig',
            ])
            ->addIdentifier('name', null, [
                'label' => 'discount.fields.name',
            ])
            ->add('game', null, [
                'label' => 'discount.fields.game',
            ])
            ->add('isMain', null, [
                'label' => 'discount.fields.is_main',
            ])
            ->add('isRandom', null, [
                'label' => 'discount.fields.is_random',
            ])
            ->add('isActive', null, [
                'label' => 'discount.fields.is_active',
            ])
            ->add('createdAt', null, [
                'label' => 'discount.fields.created_at',
                'pattern' => 'eeee, dd MMMM yyyy, HH:mm',
            ]);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, [
                'label' => 'discount.fields.name',
            ])
            ->add('game', null, [
                'label' => 'discount.fields.game',
            ])
            ->add('createdAt', null, [
                'label' => 'discount.fields.created_at',
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $context = $this->getPersistentParameter('context');

        $formMapper
            ->with('form_group.basic', ['class' => 'col-md-8', 'name' => false])
                ->add('name', TextType::class, [
                    'label' => 'discount.fields.name',
                ])
                ->add('discountHasPacks', CollectionType::class, [
                    'label' => 'discount.fields.has_pack',
                    'required' => false,
                    'constraints' => new Valid(),
                    'by_reference' => false,
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'orderNum',
                    'link_parameters' => ['context' => $context],
                    'admin_code' => 'discount.admin.discount_has_pack',
                ])
            ->end()
            ->with('form_group.additional', ['class' => 'col-md-4', 'name' => false])
                ->add('image', ModelListType::class, [
                    'label' => 'discount.fields.image',
                    'required' => false,
                ])
                ->add('game', ModelListType::class, [
                    'label' => 'discount.fields.game',
                    'required' => false,
                ])
                ->add('isActive', null, [
                    'label' => 'discount.fields.is_active',
                    'required' => false,
                ])
                ->add('isMain', null, [
                    'label' => 'discount.fields.is_main',
                    'required' => false,
                ])
                ->add('isRandom', null, [
                    'label' => 'discount.fields.is_random',
                    'required' => false,
                ])
                ->add('createdAt', DateTimePickerType::class, [
                    'label'     => 'discount.fields.created_at',
                    'required' => true,
                    'format' => 'YYYY-MM-dd HH:mm',
                    'attr' => ['readonly' => true],
                ])
            ->end();
    }
}
