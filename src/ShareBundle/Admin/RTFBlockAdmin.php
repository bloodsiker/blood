<?php

namespace ShareBundle\Admin;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class RTFBlockAdmin
 */
class RTFBlockAdmin extends Admin
{
    /**
     * @param ListMapper $list
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('id', null, [
                'label' => 'rtf_block.fields.id',
            ])
            ->addIdentifier('title', null, [
                'label' => 'rtf_block.fields.title',
            ])
            ->add('createdAt', null, [
                'label' => 'rtf_block.fields.created_at',
            ])
            ->add('alias', null, [
                'label' => 'rtf_block.fields.alias',
            ])
            ->add('isActive', null, [
                'label' => 'rtf_block.fields.is_active',
                'editable' => true,
            ])
        ;
    }

    /**
     * @param DatagridMapper $filter
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id', null, [
                'label' => 'rtf_block.fields.id',
            ])
            ->add('title', null, [
                'label' => 'rtf_block.fields.title',
            ])
            ->add('isActive', null, [
                'label' => 'rtf_block.fields.is_active',
            ])
        ;
    }

    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->with('share.form_group.basic', array('class' => 'col-md-8', 'label' => false))
                ->add('title', TextType::class, [
                    'label' => 'rtf_block.fields.title',
                    'required' => true,
                ])
                ->add('content', CKEditorType::class, [
                    'label' => 'rtf_block.fields.content',
//                    'config_name' => 'default',
                    'required' => false,
                ])
            ->end()
            ->with('share.form_group.additional', array('class' => 'col-md-4', 'label' => false))
                ->add('createdAt', DateTimeType::class, array(
                    'label' => 'rtf_block.fields.created_at',
                    'widget' => 'single_text',
                    'format' => 'eeee dd.MM.yyyy, HH:mm.ss',
                    'attr'      => array(
                        'readonly'  => true,
                    ),
                ))
                ->add('alias', null, array(
                    'label' => 'rtf_block.fields.alias',
                    'required' => false,
                    'attr'      => array(
                        'readonly'  => true,
                    ),
                ))
                ->add('isActive', CheckboxType::class, array(
                        'label' => 'rtf_block.fields.is_active',
                        'required' => false,
                ))
            ->end()
        ;
    }
}
