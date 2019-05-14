<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20190328133032
 */
final class Version20190328133032 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription()
    {
        return 'Game (GameBundle)';
    }

    /**
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function up(Schema $schema)
    {
        $genre = $schema->createTable('game_genre');
        $genre->addColumn('id', 'integer', ['unsigned' => true, 'notnull' => true, 'autoincrement' => true]);
        $genre->addColumn('name', 'string', ['length' => 255, 'notnull' => true]);
        $genre->addColumn('slug', 'string', ['length' => 255, 'notnull' => true]);
        $genre->setPrimaryKey(['id']);

        $game = $schema->createTable('game_game');
        $game->addColumn('id', 'integer', ['unsigned' => true, 'notnull' => true, 'autoincrement' => true]);
        $game->addColumn('name', 'string', ['length' => 255, 'notnull' => true]);
        $game->addColumn('slug', 'string', ['length' => 255, 'notnull' => true]);
        $game->addColumn('genre_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $game->addColumn('image_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $game->addColumn('description', 'text', ['length' => 65535, 'notnull' => true]);
        $game->addColumn('is_active', 'boolean', ['notnull' => true]);
        $game->addColumn('is_hot', 'boolean', ['notnull' => true]);
        $game->addColumn('menu_sell_to_us', 'boolean', ['notnull' => true]);
        $game->addColumn('menu_how_it_work', 'boolean', ['notnull' => true]);
        $game->addColumn('created_at', 'datetime', ['notnull' => true]);
        $game->setPrimaryKey(['id']);
        $game->addForeignKeyConstraint($genre, ['genre_id'], ['id']);
        $game->addForeignKeyConstraint($schema->getTable('media_image'), ['image_id'], ['id']);

        $server = $schema->createTable('game_server');
        $server->addColumn('id', 'integer', ['unsigned' => true, 'notnull' => true, 'autoincrement' => true]);
        $server->addColumn('name', 'string', ['length' => 255, 'notnull' => true]);
        $server->addColumn('slug', 'string', ['length' => 255, 'notnull' => true]);
        $server->addColumn('game_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $server->addColumn('is_active', 'boolean', ['notnull' => true]);
        $server->addColumn('created_at', 'datetime', ['notnull' => true]);
        $server->setPrimaryKey(['id']);
        $server->addForeignKeyConstraint($game, ['game_id'], ['id']);

        $serverHasItem = $schema->createTable('game_server_has_item');
        $serverHasItem->addColumn('id', 'integer', ['unsigned' => true, 'notnull' => true, 'autoincrement' => true]);
        $serverHasItem->addColumn('server_id', 'integer', ['unsigned' => true, 'notnull' => false]);
        $serverHasItem->addColumn('is_active', 'boolean', ['notnull' => true]);
        $serverHasItem->addColumn('order_num', 'integer', ['unsigned' => true, 'notnull' => true, 'default' => 0]);
        $serverHasItem->addColumn('price', 'decimal', ['precision' => 6, 'scale' => 2, 'unsigned' => true, 'notnull' => true, 'default' => 0]);
        $serverHasItem->addColumn('available', 'integer', ['unsigned' => true, 'notnull' => true, 'default' => 0]);
        $serverHasItem->addColumn('discount', 'decimal', ['unsigned' => true, 'notnull' => false]);
        $serverHasItem->addColumn('is_hot', 'boolean', ['notnull' => true]);
        $serverHasItem->setPrimaryKey(['id']);
        $serverHasItem->addForeignKeyConstraint($server, ['server_id'], ['id']);
        $serverHasItem->addForeignKeyConstraint($schema->getTable('share_items'), ['item_id'], ['id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('game_server_has_item');
        $schema->dropTable('game_server');
        $schema->dropTable('game_game');
        $schema->dropTable('game_genre');
    }
}
