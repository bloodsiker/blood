<?php

namespace GameBundle\Admin;

use AdminBundle\Admin\BaseAdmin as Admin;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use GameBundle\Entity\GameGenre;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class GameAdmin
 */
class GameAdmin extends Admin
{
    protected $datagridValues = [
        '_page'       => 1,
        '_per_page'   => 25,
        '_sort_by'    => 'id',
        '_sort_order' => 'ASC',
    ];

    /**
     * @param ErrorElement $errorElement
     * @param mixed        $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        if (!$object->getGenre()) {
            $errorElement
                ->with('genre')
                ->addViolation(
                    $this->trans('game.validate.genre_not_empty', [], $this->translationDomain)
                )
                ->end()
            ;
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, [
                'label' => 'game.fields.id',
            ])
            ->add('image', null, [
                'label'     => 'game.fields.image',
                'template'  => 'GameBundle:Admin:list_fields.html.twig',
            ])
            ->addIdentifier('name', null, [
                'label' => 'game.fields.name',
            ])
            ->add('isActive', null, [
                'label' => 'game.fields.is_active',
                'editable'  => true,
            ])
            ->add('isHot', null, [
                'label' => 'game.fields.is_hot',
                'editable'  => true,
            ])
            ->add('createdAt', null, [
                'label' => 'game.fields.created_at',
            ]);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, [
                'label' => 'game.fields.name',
            ])
            ->add('isActive', null, [
                'label' => 'game.fields.is_active',
            ])
            ->add('isHot', null, [
                'label' => 'game.fields.is_hot',
            ])
            ->add('createdAt', null, [
                'label' => 'game.fields.created_at',
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('game.tab.game', ['tab' => true])
                ->with('form_group.basic', ['class' => 'col-md-8', 'name' => false])
                    ->add('name', TextType::class, [
                        'label' => 'game.fields.name',
                    ])
                    ->add('description', CKEditorType::class, [
                        'label' => 'game.fields.description',
                        'required' => false,
                        'attr' => ['rows' => 5],
                    ])
                    ->add('slug', TextType::class, [
                        'label' => 'game.fields.slug',
                        'required' => false,
                        'attr' => ['readonly' => !$this->getSubject()->getId() ? false : true],
                    ])
                ->end()
                ->with('form_group.additional', ['class' => 'col-md-4', 'name' => false])
                    ->add('genre', ChoiceType::class, [
                        'label' => 'game.fields.genre',
                        'choices' => $this->getGenres(),
                        'required' => true,
                        'choice_label' => function ($status) {
                            return strtoupper($status->getName());
                        },
                    ])
                    ->add('isActive', null, [
                        'label' => 'game.fields.is_active',
                        'required' => false,
                    ])
                    ->add('isHot', null, [
                        'label' => 'game.fields.is_hot',
                        'required' => false,
                    ])
                    ->add('image', ModelListType::class, [
                        'label' => 'game.fields.image',
                        'required' => false,
                    ])
                    ->add('createdAt', DateTimePickerType::class, [
                        'label'     => 'game.fields.created_at',
                        'required' => true,
                        'format' => 'YYYY-MM-dd HH:mm',
                        'attr' => ['readonly' => true],
                    ])
                ->end()
                ->with('form_group.menu', ['class' => 'col-md-4', 'name' => false])
                    ->add('menuSellToUs', null, [
                        'label' => 'game.fields.menu.sell_to_us',
                        'required' => false,
                    ])
                    ->add('menuHowItWork', null, [
                        'label' => 'game.fields.menu.how_it_work',
                        'required' => false,
                    ])
                ->end()
            ->end()
            ->with('game.tab.sell_to_us', ['tab' => true])

            ->end();
    }

    /**
     * @return array|object[]|\OrderBundle\Entity\OrderStatus[]
     */
    private function getGenres()
    {
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');
        $repository = $em->getRepository(GameGenre::class);

        return $repository->findAll();
    }
}
