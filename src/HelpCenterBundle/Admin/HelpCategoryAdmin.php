<?php

namespace HelpCenterBundle\Admin;

use AdminBundle\Admin\BaseAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class HelpCategoryAdmin
 */
class HelpCategoryAdmin extends Admin
{
    /**
     * @var array
     */
    protected $datagridValues = [
        '_page'       => 1,
        '_per_page'   => 25,
        '_sort_by'    => 'id',
        '_sort_order' => 'DESC',
    ];

    /**
     * {@inheritdoc}
     */
    public function setTranslationDomain($translationDomain)
    {
        $this->translationDomain = $translationDomain;
        $this->formOptions['translation_domain'] = $translationDomain;
    }

    /**
     * @param ListMapper $listMapper
     *
     * @throws \Exception
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, [
                'label' => 'help_category.fields.id',
            ])
            ->addIdentifier('name', null, [
                'label' => 'help_category.fields.name',
            ])
            ->add('game', null, [
                'label' => 'help_category.fields.game',
            ])
            ->add('isActive', null, [
                'label' => 'help_category.fields.is_active',
            ]);
    }

    /**
     * @param DatagridMapper $datagridMapper
     *
     * @throws \Exception
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, [
                'label' => 'help_category.fields.name',
            ])
            ->add('game', null, [
                'label' => 'help_category.fields.game',
            ]);
    }

    /**
     * @param FormMapper $formMapper
     *
     * @throws \Exception
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form_group.basic', ['class' => 'col-md-8', 'name' => false])
                ->add('name', TextType::class, [
                    'label' => 'help_category.fields.name',
                ])
                ->add('slug', TextType::class, [
                    'label' => 'help_category.fields.slug',
                    'required' => false,
                    'attr' => ['readonly' => !$this->getSubject()->getId() ? false : true],
                ])
            ->end()
            ->with('form_group.additional', ['class' => 'col-md-4', 'name' => false])
                ->add('isActive', null, [
                    'label' => 'help_category.fields.is_active',
                    'required' => false,
                ])
                ->add('game', ModelListType::class, [
                    'label' => 'help_article.fields.game',
                    'required' => false,
                    'btn_delete' => false,
                    'btn_edit' => false,
                    'btn_add' => false,
                ])
            ->end();
    }
}
