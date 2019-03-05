<?php

namespace OrderBundle\Admin;

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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Valid;

/**
 * Class OrderAdmin
 */
class OrderAdmin extends Admin
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
                'label' => 'order.fields.id',
            ])
            ->add('clientEmail', null, [
                'label' => 'order.fields.client_email',
            ])
            ->add('gameNickName', null, [
                'label' => 'order.fields.game_nick_name',
            ])
            ->add('status', 'choice', [
                'label' => 'order.fields.status',
            ])
            ->add('createdAt', null, [
                'label' => 'order.fields.created_at',
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
            ->add('clientEmail', null, [
                'label' => 'order.fields.client_email',
            ])
            ->add('gameNickName', null, [
                'label' => 'order.fields.game_nick_name',
            ])
            ->add('status', null, [
                'label' => 'order.fields.status',
            ])
            ->add('createdAt', DateTimeFilter::class, [
                'label' => 'order.fields.created_at',
            ]);
    }

    /**
     * @param FormMapper $formMapper
     *
     * @throws \Exception
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $context = $this->getPersistentParameter('context');

        $formMapper
            ->with('form_group.basic', ['class' => 'col-md-12', 'label' => false])
                ->add('status', ChoiceType::class, [
                    'label' => 'order.fields.status',
                    'choices' => $this->getStatuses(),
                    'required' => true,
                    'choice_label' => function ($status) {
                        return strtoupper($status->getName());
                    },
                ])
                ->add('clientEmail', TextType::class, [
                    'label' => 'order.fields.client_email',
                ])
                ->add('gameNickName', TextType::class, [
                    'label' => 'order.fields.game_nick_name',
                ])
                ->add('orderHasItems', CollectionType::class, [
                    'label' => 'order.fields.items',
                    'required' => false,
                    'constraints' => new Valid(),
                    'by_reference' => false,
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'orderNum',
                    'link_parameters' => ['context' => $context],
                    'admin_code' => 'order.admin.order_has_item',
                ])
                ->add('createdAt', DateTimePickerType::class, [
                    'label'     => 'order.fields.created_at',
                    'required' => true,
                    'format' => 'YYYY-MM-dd HH:mm',
                    'attr' => ['readonly' => true],
                ])
            ->end();
    }

    /**
     * @return array|object[]|\OrderBundle\Entity\OrderStatus[]
     */
    private function getStatuses()
    {
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');
        $repository = $em->getRepository('OrderBundle:OrderStatus');

        return $repository->findAll();
    }
}
