<?php

namespace ShareBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class ItemCategoryAdmin
 */
class ItemCategoryAdmin extends Admin
{
    /**
     * @var array
     */
    protected $datagridValues = [
        '_sort_by'      => 'id',
        '_sort_order'   => 'DESC',
    ];

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('share.form_group.basic', ['class' => 'col-md-8', 'label' => false])
                ->add('name', TextType::class, [
                    'label' => 'category.fields.name',
                    'required' => true,
                ])
            ->end()
            ->with('share.form_group.additional', ['class' => 'col-md-4', 'label' => false])
                ->add('slug', TextType::class, [
                    'label' => 'category.fields.slug',
                    'required' => false,
                    'attr'      => [
                        'readonly'  => $this->getSubject()->getId() > 0,
                    ],
                ])
            ->end()
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, [
                'label' => 'category.fields.id',
            ])
            ->add('name', null, [
                'label' => 'category.fields.name',
            ])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, [
                'label' => 'category.fields.id',
            ])
            ->addIdentifier('name', null, [
                'label' => 'category.fields.name',
                'field' => 'name',
            ])
            ->add('slug', null, [
                'label' => 'category.fields.slug',
            ])
            ->add('_action', 'actions', [
                'actions' => ['edit' => []],
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('slug')
        ;
    }
}
