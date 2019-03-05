<?php

namespace ShareBundle\Admin;

use AdminBundle\Admin\BaseAdmin as Admin;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class ItemAdmin
 */
class ItemAdmin extends Admin
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
                'label' => 'item.fields.id',
            ])
            ->add('image', null, [
                'label'     => 'item.fields.image',
                'template'  => 'ShareBundle:Admin:list_fields.html.twig',
            ])
            ->addIdentifier('name', null, [
                'label' => 'item.fields.name',
            ])
            ->add('category', null, [
                'label'     => 'item.fields.category',
            ])
            ->add('createdAt', null, [
                'label' => 'item.fields.created_at',
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
                'label' => 'item.fields.name',
            ])
            ->add('category', null, [
                'label' => 'item.fields.category',
            ])
            ->add('createdAt', null, [
                'label' => 'item.fields.created_at',
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
                    'label' => 'item.fields.name',
                ])
                ->add('description', CKEditorType::class, [
                    'label' => 'item.fields.description',
                    'required' => false,
                    'attr' => ['rows' => 5],
                ])
                ->add('slug', TextType::class, [
                    'label' => 'item.fields.slug',
                    'required' => false,
                    'attr' => ['readonly' => !$this->getSubject()->getId() ? false : true],
                ])
            ->end()
            ->with('form_group.additional', ['class' => 'col-md-4', 'name' => false])
                ->add('image', ModelListType::class, [
                    'label' => 'item.fields.image',
                    'required' => false,
                ])
                ->add('category', ModelListType::class, [
                    'label' => 'item.fields.category',
                    'required' => false,
                ])
                ->add('createdAt', DateTimePickerType::class, [
                    'label'     => 'item.fields.created_at',
                    'required' => true,
                    'format' => 'YYYY-MM-dd HH:mm',
                    'attr' => ['readonly' => true],
                ])
            ->end();
    }
}
