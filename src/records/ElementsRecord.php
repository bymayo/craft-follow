<?php

namespace bymayo\follow\records;

use bymayo\follow\Follow;

use Craft;
use craft\db\ActiveRecord;

class ElementsRecord extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    public static function tableName()
    {
        return '{{%follow_elements}}';
    }
}
