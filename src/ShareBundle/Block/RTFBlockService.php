<?php

namespace ShareBundle\Block;

use Doctrine\ORM\Mapping\ClassMetadata;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\Service\AbstractAdminBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\CoreBundle\Model\Metadata;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\CoreBundle\Form\Type\ImmutableArrayType;
use Sonata\AdminBundle\Form\Type\ModelListType;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class RTFBlockService
 */
class RTFBlockService extends AbstractAdminBlockService
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var \ShareBundle\Admin\RTFBlockAdmin
     */
    protected $admin;

    /**
     * Constructor
     *
     * @param string             $name
     * @param EngineInterface    $templating
     * @param ContainerInterface $container
     */
    public function __construct($name, EngineInterface $templating, ContainerInterface $container)
    {
        parent::__construct($name, $templating);

        $this->container = $container;
    }

    /**
     * @param null $code
     *
     * @return Metadata
     */
    public function getBlockMetadata($code = null)
    {
        return new Metadata(
            $this->getName(),
            (!is_null($code) ? $code : $this->getName()),
            false,
            'ShareBundle',
            ['class' => 'fa fa-text-width']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'rtf_block' => null,
            'template' => 'ShareBundle:Block:rtf.html.twig',
        ));
    }

    /**
     * {@inheritdoc}
     */
//    public function buildEditForm(FormMapper $form, BlockInterface $block)
//    {
//        $form->add('settings', 'sonata_type_immutable_array', array(
//            'translation_domain' => 'ShareBundle',
//            'keys' => array(
//                array($this->getRTFBuilder($form), null, array()),
//            ),
//        ));
//    }

    /**
     * @param FormMapper     $formMapper
     * @param BlockInterface $block
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper->add('settings', ImmutableArrayType::class, [
            'translation_domain' => 'AppBundle',
            'label' => false,
            'keys' => [
                [$this->getRTFBuilder($formMapper), null, [] ],
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
        $errorElement
            ->with('settings[rtf_block]')
                ->addConstraint(new Assert\NotNull())
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist(BlockInterface $block)
    {
        $block->setSetting('rtf_block', is_object($block->getSetting('rtf_block')) ? $block->getSetting('rtf_block')->getId() : null);
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate(BlockInterface $block)
    {
        $this->prePersist($block);
    }

    /**
     * {@inheritdoc}
     */
    public function load(BlockInterface $block)
    {
        $rtfBlock = $block->getSetting('rtf_block');

        if ($rtfBlock) {
            $rtfBlock = $this->container->get('doctrine')->getManager()->getRepository('ShareBundle:RTFBlock')->findOneBy(array('id' => $rtfBlock));
        }

        $block->setSetting('rtf_block', $rtfBlock);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $block = $blockContext->getBlock();

        if (!$block->getEnabled()) {
            return new Response();
        }

        $rtfBlock = $block->getSetting('rtf_block');

        return $this->renderResponse($blockContext->getTemplate(), array(
            'rtf_block' => $rtfBlock,
            'block' => $block,
            'settings' => $blockContext->getSettings(),
        ), $response);
    }

    /**
     * @param FormMapper $formMapper
     *
     * @return \Symfony\Component\Form\FormBuilder
     */
    protected function getRTFBuilder(FormMapper $formMapper)
    {
        $fieldDescription = $this->getRTFAdmin()
            ->getModelManager()
            ->getNewFieldDescriptionInstance($this->admin->getClass(), 'rtf_block');

        $fieldDescription->setAssociationAdmin($this->getRTFAdmin());
        $fieldDescription->setAdmin($formMapper->getAdmin());
        $fieldDescription->setAssociationMapping(array(
            'fieldName' => 'rtf_block',
            'type' => ClassMetadata::ONE_TO_MANY,
        ));

        $fieldDescription->setOption('translation_domain', 'ShareBundle');

        return $formMapper->create('rtf_block', ModelListType::class, array(
            'translation_domain' => 'ShareBundle',
            'sonata_field_description' => $fieldDescription,
            'class' => $this->getRTFAdmin()->getClass(),
            'model_manager' => $this->getRTFAdmin()->getModelManager(),
            'label' => 'share.block.field.rtf_block',
            'required' => true,
        ));
    }

    /**
     * @return \ShareBundle\Admin\RTFBlockAdmin
     */
    protected function getRTFAdmin()
    {
        if (!$this->admin) {
            $this->admin = $this->container->get('share.admin.rtf_block');
        }

        return $this->admin;
    }
}
