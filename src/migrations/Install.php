<?php

namespace bymayo\follow\migrations;

use bymayo\follow\Follow;

use Craft;
use craft\config\DbConfig;
use craft\db\Migration;

class Install extends Migration
{

    // Public Methods
    // =========================================================================

    public function safeUp()
    {

        if ($this->createTables()) {
            $this->createIndexes();
            $this->addForeignKeys();
            // Craft::$app->db->schema->refresh();
            $this->insertDefaultData();
        }

        return true;
    }

    public function safeDown()
    {

        $this->removeTables();

        return true;
    }

    // Protected Methods
    // =========================================================================

    protected function createTables()
    {
        $tablesCreated = false;

        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%follow_elements}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%follow_elements}}',
                [
                    'id' => $this->primaryKey(),
                    'userId' => $this->integer()->notNull(),
                    'elementId' => $this->integer()->notNull(),
                    'elementClass' => $this->string(255),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'uid' => $this->uid(),
                    'siteId' => $this->integer()->notNull()
                ]
            );
        }

        return $tablesCreated;
    }

    protected function createIndexes()
    {
    }

    protected function addForeignKeys()
    {

      $this->addForeignKey(
          $this->db->getForeignKeyName('{{%follow_elements}}', 'userId'),
          '{{%follow_elements}}',
          'userId',
          '{{%users}}',
          'id',
          'CASCADE',
          'CASCADE'
      );

      $this->addForeignKey(
          $this->db->getForeignKeyName('{{%follow_elements}}', 'elementId'),
          '{{%follow_elements}}',
          'elementId',
          '{{%elements}}',
          'id',
          'CASCADE',
          'CASCADE'
      );

      $this->addForeignKey(
          $this->db->getForeignKeyName('{{%follow_elements}}', 'siteId'),
          '{{%follow_elements}}',
          'siteId',
          '{{%sites}}',
          'id',
          'CASCADE',
          'CASCADE'
      );

    }

    protected function insertDefaultData()
    {
    }

    protected function removeTables()
    {
        $this->dropTableIfExists('{{%follow_elements}}');
    }

}
