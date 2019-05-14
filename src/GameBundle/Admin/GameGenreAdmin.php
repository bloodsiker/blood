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
 * Class GameGenreAdmin
 */
class GameGenreAdmin extends Admin
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
                'label' => 'game_genre.fields.id',
            ])
            ->addIdentifier('name', null, [
                'label' => 'game_genre.fields.name',
            ])
            ->add('slug', null, [
                'label' => 'game_genre.fields.slug',
            ]);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, [
                'label' => 'game_genre.fields.name',
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form_group.basic', ['class' => 'col-md-12', 'name' => false])
                ->add('name', TextType::class, [
                    'label' => 'game_genre.fields.name',
                ])
                ->add('slug', TextType::class, [
                    'label' => 'game_genre.fields.slug',
                    'required' => false,
                    'attr' => ['readonly' => true],
                ])
            ->end()
            ;
    }
}
