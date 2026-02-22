<?php

namespace bymayo\follow\migrations;

use craft\db\Migration;

class m260222_000000_addIndexes extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createIndex(null, '{{%follow_elements}}', ['userId', 'elementId'], true);
        $this->createIndex(null, '{{%follow_elements}}', ['elementId']);
        $this->createIndex(null, '{{%follow_elements}}', ['userId', 'elementClass']);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropIndex($this->db->getIndexName('{{%follow_elements}}', ['userId', 'elementId'], true), '{{%follow_elements}}');
        $this->dropIndex($this->db->getIndexName('{{%follow_elements}}', ['elementId']), '{{%follow_elements}}');
        $this->dropIndex($this->db->getIndexName('{{%follow_elements}}', ['userId', 'elementClass']), '{{%follow_elements}}');
    }
}
