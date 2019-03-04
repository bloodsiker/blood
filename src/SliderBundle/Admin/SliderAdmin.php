<?php

namespace SliderBundle\Admin;

use AdminBundle\Admin\BaseAdmin as Admin;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class SliderAdmin
 */
class SliderAdmin extends Admin
{
    /**
     * @var array
     */
    protected $datagridValues = [
        '_page'       => 1,
        '_per_page'   => 25,
        '_sort_by'    => 'id',
        '_sort_order' => 'ASC',
    ];

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, [
                'label' => 'slider.fields.id',
            ])
            ->add('image', null, [
                'label'     => 'slider.fields.image',
                'template'  => 'SliderBundle:Admin:list_fields.html.twig',
            ])
            ->addIdentifier('game', null, [
                'label' => 'slider.fields.game',
            ])
            ->add('title', null, [
                'label' => 'slider.fields.title',
            ])
            ->add('isActive', null, [
                'label' => 'slider.fields.is_active',
                'editable'  => true,
            ])
            ->add('createdAt', null, [
                'label' => 'slider.fields.created_at',
                'pattern' => 'eeee, dd MMMM yyyy, HH:mm',
            ])
            ->add('_action', 'actions', [
                'actions' => ['edit' => []],
            ]);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('game', null, [
                'label' => 'slider.fields.game',
            ])
            ->add('isActive', null, [
                'label' => 'slider.fields.is_active',
            ])
            ->add('createdAt', null, [
                'label' => 'slider.fields.created_at',
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form_group.basic', ['class' => 'col-md-8', 'name' => false])
                ->add('title', TextType::class, [
                    'label' => 'slider.fields.title',
                    'required' => false,
                ])
                ->add('description', TextareaType::class, [
                    'label' => 'slider.fields.description',
                    'required' => true,
                    'attr' => [
                        'rows' => 5,
                    ],
                ])
            ->end()
            ->with('form_group.additional', ['class' => 'col-md-4', 'name' => false])
                ->add('isActive', null, [
                    'label' => 'slider.fields.is_active',
                    'required' => false,
                ])
                ->add('image', ModelListType::class, [
                    'label' => 'slider.fields.image',
                    'required' => false,
                ])
                ->add('game', ModelListType::class, [
                    'label' => 'slider.fields.game',
                    'required' => false,
                ])
                ->add('createdAt', DateTimePickerType::class, [
                    'label'     => 'slider.fields.created_at',
                    'required' => true,
                    'format' => 'YYYY-MM-dd HH:mm',
                    'attr' => ['readonly' => true],
                ])
            ->end();
    }
}
