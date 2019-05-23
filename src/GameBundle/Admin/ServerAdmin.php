<?php

namespace GameBundle\Admin;

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
 * Class ServerAdmin
 */
class ServerAdmin extends Admin
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
                'label' => 'server.fields.id',
            ])
            ->addIdentifier('name', null, [
                'label' => 'server.fields.name',
            ])
            ->add('game', null, [
                'label' => 'server.fields.game',
            ])
            ->add('isActive', null, [
                'label' => 'server.fields.is_active',
                'editable'  => true,
            ])
            ->add('createdAt', null, [
                'label' => 'server.fields.created_at',
            ]);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, [
                'label' => 'server.fields.name',
            ])
            ->add('game', null, [
                'label' => 'server.fields.game',
            ])
            ->add('isActive', null, [
                'label' => 'server.fields.is_active',
            ])
            ->add('createdAt', null, [
                'label' => 'server.fields.created_at',
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form_group.basic', ['class' => 'col-md-8', 'name' => false])
                ->add('name', TextType::class, [
                    'label' => 'server.fields.name',
                ])
                ->add('slug', TextType::class, [
                    'label' => 'server.fields.slug',
                    'required' => false,
                    'attr' => ['readonly' => !$this->getSubject()->getId() ? false : true],
                ])
            ->end()
            ->with('form_group.additional', ['class' => 'col-md-4', 'name' => false])
                ->add('isActive', null, [
                    'label' => 'server.fields.is_active',
                    'required' => false,
                ])
                ->add('game', ModelListType::class, [
                    'label' => 'server.fields.game',
                    'required' => false,
                    'btn_edit' => false,
                ])
                ->add('createdAt', DateTimePickerType::class, [
                    'label'     => 'server.fields.created_at',
                    'required' => true,
                    'format' => 'YYYY-MM-dd HH:mm',
                    'attr' => ['readonly' => true],
                ])
            ->end();
    }
}
