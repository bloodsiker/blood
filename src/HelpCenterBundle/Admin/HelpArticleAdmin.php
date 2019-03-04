<?php

namespace HelpCenterBundle\Admin;

use AdminBundle\Admin\BaseAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\DoctrineORMAdminBundle\Filter\DateTimeFilter;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * Class HelpArticleAdmin
 */
class HelpArticleAdmin extends Admin
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
                'label' => 'help_article.fields.id',
            ])
            ->addIdentifier('title', null, [
                'label' => 'help_article.fields.title',
            ])
            ->add('category', null, [
                'label' => 'help_article.fields.category',
            ])
            ->add('game', null, [
                'label' => 'help_article.fields.game',
            ])
            ->add('isActive', null, [
                'label' => 'help_article.fields.is_active',
            ])
            ->add('createdAt', null, [
                'label' => 'help_article.fields.created_at',
            ])
            ->add('_action', 'actions', [
                'actions' => ['edit' => []],
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
            ->add('title', null, [
                'label' => 'help_article.fields.title',
            ])
            ->add('category', null, [
                'label' => 'help_article.fields.category',
            ])
            ->add('game', null, [
                'label' => 'help_article.fields.game',
            ])
            ->add('isActive', null, [
                'label' => 'help_article.fields.is_active',
            ])
            ->add('createdAt', DateTimeFilter::class, [
                'label' => 'help_article.fields.created_at',
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
                ->add('title', TextType::class, [
                    'label' => 'help_article.fields.title',
                ])
                ->add('description', TextareaType::class, [
                    'label' => 'help_article.fields.description',
                    'required' => true,
                    'attr' => [
                        'rows' => 5,
                    ],
                ])
            ->end()
            ->with('form_group.additional', ['class' => 'col-md-4', 'name' => false])
                ->add('isActive', null, [
                    'label' => 'help_article.fields.is_active',
                    'required' => false,
                ])
                ->add('category', ModelListType::class, [
                    'label' => 'help_article.fields.category',
                    'required' => false,
                ])
                ->add('game', ModelListType::class, [
                    'label' => 'help_article.fields.game',
                    'required' => false,
                ])
                ->add('createdAt', DateTimePickerType::class, [
                    'label'     => 'order.fields.created_at',
                    'required' => true,
                    'format' => 'YYYY-MM-dd HH:mm',
                    'attr' => ['readonly' => true],
                ])
            ->end();
    }
}
