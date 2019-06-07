<?php

namespace MenuBundle\Admin;

use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class MenuAdmin
 */
class MenuAdmin extends Admin
{
    /**
     * @var array
     */
    protected $datagridValues = [
        '_page'       => 1,
        '_per_page'   => 64,
        '_sort_by'    => 'type, orderNum',
        '_sort_order' => 'ASC',
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
     * @return mixed
     */
    public function getNewInstance()
    {
        $instance = parent::getNewInstance();
        $instance->setOrderNum(1);
        $instance->setIsActive(true);

        $type = $this->getRequest()->get('type', null);
        if ($this->hasRequest() && null !== $type) {
            $instance->setType($type);
        }

        return $instance;
    }

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->hasRequest()) {
            return [];
        }

        $parameters = array_filter($this->getRequest()->query->all(), function ($param) {
            return !is_array($param);
        });

        if (!isset($parameters['type'])) {
            $parameters['type'] = null;
        }

        return $parameters;
    }

    /**
     * @param string $context
     *
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        if ('list' === $context) {
            $type = $this->getRequest()->get('type', null);

            if (null !== $type) {
                $query->andWhere(
                    $query->expr()->eq($query->getRootAlias().'.type', ':type')
                );
                $query->setParameter('type', $type);
            }
        }

        return $query;
    }

    /**
     * @param MenuItemInterface   $menu
     * @param string              $action
     * @param AdminInterface|null $childAdmin
     *
     * @return mixed|void
     *
     * @throws \Exception
     */
    protected function configureTabMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if (in_array($action, ['list'])) {
            $admin = $this->isChild() ? $this->getParent() : $this;
            $type = (int) $admin->getRequest()->get('type', 1);

            $menu->setAttributes(['class' => 'navbar-top-links breadcrumb']);
            $menu->setCurrent($this->getRequest()->getBaseUrl().$this->getRequest()->getRequestUri());

            foreach($this->getMenuTypes() as $name => $alias) {
                $menu->addChild($this->trans($name, [], $this->translationDomain),
                    [
                        'uri' => $this->generateUrl($action, ['type' => $alias]),
                        'attributes' => ['class' => $type === $alias ? 'active' : ''],
                    ]
                );
            }
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', null, [
                'label' => 'menu.fields.title',
                'field' => 'title',
                'template' => 'MenuBundle:Admin:translatable.html.twig',
            ])
            ->add('url', null, [
                'label' => 'menu.fields.url',
                'field' => 'page',
                'template' => 'MenuBundle:Admin:translatable.html.twig',
            ])
            ->add('isActive', null, [
                'label' => 'menu.fields.is_active',
                'editable'  => true,
            ])
            ->add('isBlank', null, [
                'label' => 'menu.fields.is_blank',
                'editable'  => true,
            ])
            ->add('page', null, [
                'label' => 'menu.fields.page',
            ])
            ->add('_action', 'actions', [
                'actions' => [
//                    'delete'    => [],
//                    'do_first'  => ['template' => 'AdminBundle:CRUD:list__action_do_first.html.twig'],
                    'move_up'   => ['template' => 'AdminBundle:CRUD:list__action_move_up.html.twig'],
                    'order_num' => ['template' => 'AdminBundle:CRUD:list__action_order_num.html.twig'],
                    'move_down' => ['template' => 'AdminBundle:CRUD:list__action_move_down.html.twig'],
//                    'do_last'   => ['template' => 'AdminBundle:CRUD:list__action_do_last.html.twig'],
                ],
            ])
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title', null, [
                'label' => 'menu.fields.title',
            ])
            ->add('isActive', null, [
                'label' => 'menu.fields.is_active',
            ])
            ->add('isBlank', null, [
                'label' => 'menu.fields.is_blank',
            ])
            ->add('type', null, ['label' => 'menu.fields.type'], ChoiceType::class, [
                'choices'                   => $this->getMenuTypes(),
                'choice_translation_domain' => $this->getTranslationDomain(),
                'expanded' => false,
                'multiple' => false,
            ])
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $type = $this->getRequest()->get('type', null);

        $site = $this->getConfigurationPool()
            ->getContainer()
            ->get('sonata.page.site.selector')
            ->retrieve()
        ;

        $formMapper
            ->with('menu_form_group.basic', ['class' => 'col-md-4', 'label' => false])
                ->add('title', TextType::class, [
                    'label'     => 'menu.fields.title',
                    'required'  => false,
                ])
                ->add('url', TextType::class, [
                    'label'     => 'menu.fields.url',
                    'required'  => false,
                ])
            ->end()
            ->with('menu_form_group.styles', ['class' => 'col-md-4', 'label' => false])
                ->add('type', ChoiceType::class, [
                    'label'     => 'menu.fields.type',
                    'choices'   => $this->getMenuTypes(),
                    'required'  => true,
                ])
                ->add('orderNum', IntegerType::class, [
                    'label' => 'menu.fields.order_num',
                    'required' => false,
                    'attr' => [
                        'min' => 0,
                    ],
                ])
                ->add('itemClass', TextType::class, [
                    'label'     => 'menu.fields.item_class',
                    'required'  => false,
                ])
                ->add('isBlank', CheckboxType::class, [
                    'label'     => 'menu.fields.is_blank',
                    'required'  => false,
                ])
                ->add('isActive', CheckboxType::class, [
                    'label'     => 'menu.fields.is_active',
                    'required'  => false,
                ])
            ->end()
            ->with('menu_form_group.additional', ['class' => 'col-md-4', 'label' => false])
                ->add('parent', ModelListType::class, [
                    'label' => 'menu.fields.parent',
                    'required' => false,
                ], [
                    'link_parameters' => [
                        'filter[type][value]' => $type !== null ? (int) $type : $this->getSubject()->getType(),
                    ],
                ])
                ->add('game', ModelListType::class, [
                    'label' => 'menu.fields.game',
                    'required' => false,
                ])
                ->add('page', ModelListType::class, [
                    'label'     => 'menu.fields.page',
                    'required'  => false,
                    'btn_add'   => false,
                ], [
                    'link_parameters' => [
                        'filter[site][value]' => $site ? $site->getId() : null,
                    ],
                ])
            ->end()
        ;
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('moveup', $this->getRouterIdParameter().'/move-up');
        $collection->add('movedown', $this->getRouterIdParameter().'/move-down');
//        $collection->add('do_first', $this->getRouterIdParameter().'/do-first');
//        $collection->add('do_last', $this->getRouterIdParameter().'/do-last');
        $collection->add('recalculate_order_num', $this->getRouterIdParameter().'/recalculate-order-num');
    }

    /**
     * @return array
     */
    public function getMenuTypes()
    {
        $typeChoice = [];
        $entity = $this->getClass();
        $types = $entity::getTypeList();

        foreach ($types as $key => $value) {
            $typeChoice['menu.types.'.$value] = $key;
        }

        return $typeChoice;
    }
}
