<?php

namespace bymayo\follow\models;

use bymayo\follow\Follow;

use Craft;
use craft\base\Model;

class Settings extends Model
{
   
    // Public Properties
    // =========================================================================

    public $allowedElementClasses = array(
      'craft\elements\User',
      'craft\elements\Tag',
      'craft\elements\Category'
   );

    // Public Methods
    // =========================================================================

    public function rules()
    {
        return [
            [['allowedElementClasses'], 'array']
        ];
    }

}
