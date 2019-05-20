<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20190328131899
 */
final class Version20190328131899 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription()
    {
        return 'Product (ProductBundle)';
    }

    /**
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function up(Schema $schema)
    {
        $product = $schema->createTable('product_product');
        $product->addColumn('id', 'integer', ['unsigned' => true, 'notnull' => true, 'autoincrement' => true]);
        $product->addColumn('server_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $product->addColumn('item_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $product->addColumn('price', 'decimal', ['precision' => 6, 'scale' => 2, 'unsigned' => true, 'notnull' => true, 'default' => 0]);
        $product->addColumn('available', 'integer', ['unsigned' => true, 'notnull' => true, 'default' => 0]);
        $product->addColumn('discount', 'decimal', ['unsigned' => true, 'notnull' => false]);
        $product->addColumn('is_active', 'boolean', ['notnull' => true]);
        $product->addColumn('is_hot', 'boolean', ['notnull' => true]);
        $product->addColumn('created_at', 'datetime', ['notnull' => true]);
        $product->setPrimaryKey(['id']);
        $product->addForeignKeyConstraint($schema->getTable('game_server'), ['server_id'], ['id']);
        $product->addForeignKeyConstraint($schema->getTable('share_items'), ['item_id'], ['id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('product_product');
    }
}
