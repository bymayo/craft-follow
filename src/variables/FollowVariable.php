<?php

namespace bymayo\follow\variables;

use bymayo\follow\Follow;

use craft\helpers\UrlHelper;

use Craft;

class FollowVariable
{

   // Public Methods
   // =========================================================================

   public function followUrl($elementId)
   {
      return UrlHelper::actionUrl('follow/element/follow', array('elementId' => $elementId));
   }

   public function unfollowUrl($elementId)
   {
      return UrlHelper::actionUrl('follow/element/unfollow', array('elementId' => $elementId));
   }

   public function check($elementId, $userId = null)
   {
      // Returns BOOL / True / False
      return Follow::getInstance()->elementService->check($elementId, $userId);
   }

   public function following($params = null)
   {
      // Returns list of ID's
      return Follow::getInstance()->elementService->following($params);
   }

   public function followers($elementId = null)
   {
      // Returns list of ID's
      return Follow::getInstance()->elementService->followers($elementId);
   }

}
