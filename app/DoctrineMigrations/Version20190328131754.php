<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20190328131754
 */
final class Version20190328131754 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription()
    {
        return 'Items, Category, RTF (ShareBundle)';
    }

    /**
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function up(Schema $schema)
    {
        $category = $schema->createTable('share_category');
        $category->addColumn('id', 'integer', ['unsigned' => true, 'notnull' => true, 'autoincrement' => true]);
        $category->addColumn('name', 'string', ['length' => 255, 'notnull' => true]);
        $category->addColumn('slug', 'string', ['length' => 255, 'notnull' => true]);
        $category->setPrimaryKey(['id']);

        $item = $schema->createTable('share_item');
        $item->addColumn('id', 'integer', ['unsigned' => true, 'notnull' => true, 'autoincrement' => true]);
        $item->addColumn('name', 'string', ['length' => 255, 'notnull' => true]);
        $item->addColumn('slug', 'string', ['length' => 255, 'notnull' => true]);
        $item->addColumn('image_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $item->addColumn('description', 'text', ['length' => 65535, 'notnull' => true]);
        $item->addColumn('created_at', 'datetime', ['notnull' => true]);
        $item->setPrimaryKey(['id']);
        $item->addForeignKeyConstraint($schema->getTable('media_image'), ['image_id'], ['id']);

        // bookTags
        $itemCategory = $schema->createTable('share_item_category');
        $itemCategory->addColumn('item_id', 'integer', array('unsigned' => true, 'notnull' => true));
        $itemCategory->addColumn('category_id', 'integer', array('unsigned' => true, 'notnull' => true));
        $itemCategory->addIndex(['item_id', 'category_id']);
        $itemCategory->addForeignKeyConstraint($item, ['item_id'], ['id'], ['onDelete' => 'cascade']);
        $itemCategory->addForeignKeyConstraint($category, ['category_id'], ['id'], ['onDelete' => 'cascade']);

        // rtf-blocks
        $rtfBlock = $schema->createTable('share_rtf_block');
        $rtfBlock->addColumn('id', 'integer', ['unsigned' => true, 'notnull' => true, 'autoincrement' => true]);
        $rtfBlock->addColumn('title', 'string', ['length' => 255, 'notnull' => true]);
        $rtfBlock->addColumn('content', 'text', ['length' => 65535, 'notnull' => false]);
        $rtfBlock->addColumn('alias', 'string', ['length' => 64, 'notnull' => false]);
        $rtfBlock->addColumn('created_at', 'datetime', ['notnull' => true]);
        $rtfBlock->addColumn('is_active', 'boolean', ['notnull' => true]);
        $rtfBlock->setPrimaryKey(['id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('share_item');
        $schema->dropTable('share_category');
        $schema->dropTable('share_rtf_block');
    }
}
