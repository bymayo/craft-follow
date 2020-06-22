<?php

namespace bymayo\follow\migrations;

use Craft;
use craft\db\Migration;

/**
 * m200622_140045_createRequestsTable migration.
 */
class m200622_140045_createRequestsTable extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {

        $this->createTable(
            '{{%follow_requests}}',
            [
                 'id' => $this->primaryKey(),
                 'userId' => $this->integer()->notNull(),
                 'elementId' => $this->integer()->notNull(),
                 'dateCreated' => $this->dateTime()->notNull(),
                 'dateUpdated' => $this->dateTime()->notNull(),
                 'uid' => $this->uid(),
                 'siteId' => $this->integer()->notNull()->defaultValue(1)
            ]
         );

         $this->addForeignKey(
            $this->db->getForeignKeyName('{{%follow_requests}}', 'userId'),
            '{{%follow_requests}}',
            'userId',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
  
        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%follow_requests}}', 'elementId'),
            '{{%follow_requests}}',
            'elementId',
            '{{%elements}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m200622_140045_createRequestsTable cannot be reverted.\n";
        return false;
    }
}
