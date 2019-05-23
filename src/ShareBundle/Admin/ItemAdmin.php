<?php

namespace ShareBundle\Admin;

use AdminBundle\Admin\BaseAdmin as Admin;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\DoctrineORMAdminBundle\Filter\DateTimeFilter;
use Sonata\DoctrineORMAdminBundle\Filter\ModelAutocompleteFilter;
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
            ->add('categories', null, [
                'label'     => 'item.fields.categories',
                'template' => 'ShareBundle:Admin:list_category.html.twig',
            ])
            ->add('createdAt', null, [
                'label' => 'item.fields.created_at',
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
            ->add('categories', ModelAutocompleteFilter::class, [
                'label' => 'item.fields.categories',
            ], null, ['property' => 'name'])
            ->add('createdAt', DateTimeFilter::class, [
                'label' => 'item.fields.created_at',
                'field_type'    => DateTimePickerType::class,
                'field_options' => array('format' => 'dd.MM.yyyy'),
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
                    'config_name' => 'advanced',
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
                ->add('categories', ModelAutocompleteType::class, [
                    'label' => 'item.fields.categories',
                    'required' => false,
                    'property' => 'name',
                    'multiple' => true,
                    'attr' => ['class' => 'form-control'],
                    'btn_catalogue' => $this->translationDomain,
                    'minimum_input_length' => 2,
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
