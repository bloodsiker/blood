<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20190329123851
 */
final class Version20190329123851 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription()
    {
        return 'Discount (DiscountPuckBundle)';
    }

    /**
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function up(Schema $schema)
    {
        $pack = $schema->createTable('discount_pack');
        $pack->addColumn('id', 'integer', ['unsigned' => true, 'notnull' => true, 'autoincrement' => true]);
        $pack->addColumn('name', 'string', ['length' => 255, 'notnull' => true]);
        $pack->addColumn('price', 'decimal', ['precision' => 6, 'scale' => 2, 'unsigned' => true, 'notnull' => true, 'default' => 0]);
        $pack->addColumn('discount', 'decimal', ['unsigned' => true, 'notnull' => false]);
        $pack->addColumn('created_at', 'datetime', ['notnull' => true]);
        $pack->setPrimaryKey(['id']);

        $packHasItem = $schema->createTable('discount_pack_has_item');
        $packHasItem->addColumn('id', 'integer', ['unsigned' => true, 'notnull' => true, 'autoincrement' => true]);
        $packHasItem->addColumn('pack_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $packHasItem->addColumn('item_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $packHasItem->addColumn('is_active', 'boolean', ['notnull' => true]);
        $packHasItem->addColumn('order_num', 'integer', ['unsigned' => true, 'notnull' => true, 'default' => 0]);
        $packHasItem->addColumn('price', 'decimal', ['precision' => 6, 'scale' => 2, 'unsigned' => true, 'notnull' => true, 'default' => 0]);
        $packHasItem->addColumn('available', 'integer', ['unsigned' => true, 'notnull' => true, 'default' => 0]);
        $packHasItem->addColumn('is_hot', 'boolean', ['notnull' => true]);
        $packHasItem->setPrimaryKey(['id']);
        $packHasItem->addForeignKeyConstraint($pack, ['pack_id'], ['id']);
        $packHasItem->addForeignKeyConstraint($schema->getTable('share_items'), ['item_id'], ['id']);

        $discount = $schema->createTable('discount_discount');
        $discount->addColumn('id', 'integer', ['unsigned' => true, 'notnull' => true, 'autoincrement' => true]);
        $discount->addColumn('name', 'string', ['length' => 255, 'notnull' => true]);
        $discount->addColumn('image_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $discount->addColumn('game_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $discount->addColumn('order_num', 'integer', ['unsigned' => true, 'notnull' => true, 'default' => 0]);
        $discount->addColumn('is_active', 'boolean', ['notnull' => true]);
        $discount->addColumn('is_main', 'boolean', ['notnull' => true]);
        $discount->addColumn('is_random', 'boolean', ['notnull' => true]);
        $discount->addColumn('created_at', 'datetime', ['notnull' => true]);
        $discount->setPrimaryKey(['id']);
        $discount->addForeignKeyConstraint($schema->getTable('media_image'), ['image_id'], ['id']);
        $discount->addForeignKeyConstraint($schema->getTable('game_game'), ['game_id'], ['id']);

        $discountHasPack = $schema->createTable('discount_discount_has_pack');
        $discountHasPack->addColumn('id', 'integer', ['unsigned' => true, 'notnull' => true, 'autoincrement' => true]);
        $discountHasPack->addColumn('discount_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $discountHasPack->addColumn('pack_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $discountHasPack->addColumn('order_num', 'integer', ['unsigned' => true, 'notnull' => true, 'default' => 0]);
        $discountHasPack->addColumn('is_active', 'boolean', ['notnull' => true]);
        $discountHasPack->setPrimaryKey(['id']);
        $discountHasPack->addForeignKeyConstraint($pack, ['pack_id'], ['id']);
        $discountHasPack->addForeignKeyConstraint($discount, ['discount_id'], ['id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('discount_discount');
        $schema->dropTable('discount_discount_has_pack');
        $schema->dropTable('discount_pack');
        $schema->dropTable('discount_pack_has_item');
    }
}
