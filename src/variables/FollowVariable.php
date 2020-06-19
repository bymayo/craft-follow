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

   public function check($params = null)
   {
      return Follow::getInstance()->elementService->check($params);
   }

   public function following($params = null)
   {
      return Follow::getInstance()->elementService->following($params);
   }

   public function followers($elementId = null)
   {
      return Follow::getInstance()->elementService->followers($elementId);
   }

   public function followingTotal($params = null)
   {
      return Follow::getInstance()->elementService->followingTotal($params);
   }

   public function followersTotal($elementId = null)
   {
      return Follow::getInstance()->elementService->followingTotal($elementId);
   }

}
