<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use MenuBundle\Entity\Menu;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Version20190523140816
 */
final class Version20190523140816 extends AbstractMigration implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return "Menu (MenuBundle)";
    }

    /**
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function up(Schema $schema) : void
    {
        // menu
        $menu = $schema->createTable('menu_menu');
        $menu->addColumn('id', 'integer', array('unsigned' => true, 'notnull' => true, 'autoincrement' => true));
        $menu->addColumn('parent_id', 'integer', array('unsigned' => true, 'notnull' => false));
        $menu->addColumn('title', 'string', array('length' => 64, 'notnull' => false));
        $menu->addColumn('url', 'string', array('length' => 300, 'notnull' => false));
        $menu->addColumn('page', 'integer', array('unsigned' => true, 'notnull' => false));
        $menu->addColumn('item_class', 'string', array('length' => 32, 'notnull' => false));
        $menu->addColumn('created_at', 'datetime', array('notnull' => true));
        $menu->addColumn('created_by', 'integer', array('unsigned' => true, 'notnull' => false));
        $menu->addColumn('type', 'integer', array('columnDefinition' => 'TINYINT(10) UNSIGNED DEFAULT 0 NOT NULL'));
        $menu->addColumn('is_active', 'boolean', array('notnull' => true));
        $menu->addColumn('is_blank', 'boolean', array('notnull' => true));
        $menu->addColumn('order_num', 'integer', array('notnull' => true, 'default' => 0, 'notnull' => true));
        $menu->setPrimaryKey(array('id'));
        $menu->addIndex(array('is_active'));
        $menu->addForeignKeyConstraint($schema->getTable('menu_menu'), array('parent_id'), array('id'), array('onDelete' => 'set null'));
        $menu->addForeignKeyConstraint($schema->getTable('page_page'), array('page'), array('id'), array('onDelete' => 'set null'));
        $menu->addForeignKeyConstraint($schema->getTable('user_users'), array('created_by'), array('id'), array('onDelete' => 'set null'));
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) : void
    {
        $schema->dropTable('menu_menu');
    }

    /**
     * @param Schema $schema
     *
     * @return boolean
     */
    public function postUp(Schema $schema)
    {
        $headerMenu = [
            [
                'title' => 'Home',
                'url' => '/',
                'route' => '',
                'childs' => [],
                'type' => Menu::TYPE_HEADER,
            ],
            [
                'title' => 'Games',
                'url' => '',
                'route' => 'game_list',
                'childs' => [],
                'type' => Menu::TYPE_HEADER,
            ],
            [
                'title' => 'Items',
                'url' => '',
                'route' => 'items',
                'childs' => [],
                'type' => Menu::TYPE_HEADER,
            ],
            [
                'title' => 'Sell to us',
                'url' => '',
                'route' => 'sell_to_us',
                'childs' => [],
                'type' => Menu::TYPE_HEADER,
            ],
            [
                'title' => 'Help center',
                'url' => '',
                'route' => 'help_center',
                'childs' => [],
                'type' => Menu::TYPE_HEADER,
            ],
        ];

        $this->saveMenu($headerMenu);
    }

    /**
     * @param array     $menus
     * @param Menu|null $parent
     *
     * @return bool
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function saveMenu($menus, Menu $parent = null)
    {
        $createdAt = new \DateTime('now');

        $em = $this->container->get('doctrine.orm.entity_manager');

        $pageRepository = $em->getRepository('PageBundle:Page');

        $order = 0;
        foreach ($menus as $item) {
            $menu = new Menu();

            if ($item['route']) {
                $page = $pageRepository->findOneBy(['routeName' => $item['route']]);
                $menu->setPage($page);
            }

            $menu->setTitle($item['title']);
            $menu->setUrl($item['url']);
            $menu->setParent($parent);
            $menu->setOrderNum($order);
            $menu->setIsBlank(false);
            $menu->setIsActive(true);
            $menu->setType($item['type']);
            $menu->setCreatedAt($createdAt);

            $em->persist($menu);
            $em->flush();
            $order++;
        }

        return true;
    }
}
