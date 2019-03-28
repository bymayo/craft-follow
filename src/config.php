<?php

/**
 * Follow config.php
 *
 * This file exists only as a template for the Follow settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'follow.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

return [
   '*' => [
      'allowedElementClasses' => [
         'craft\elements\User',
         'craft\elements\Tag',
         'craft\elements\Category'
      ]
   ]
];
