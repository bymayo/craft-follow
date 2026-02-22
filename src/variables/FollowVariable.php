<?php

namespace bymayo\follow\variables;

use bymayo\follow\Follow;

use craft\helpers\UrlHelper;

use Craft;

class FollowVariable
{

   // Public Methods
   // =========================================================================

   /*
      Elements
   */

   public function followUrl()
   {
      return UrlHelper::actionUrl('follow/element/follow');
   }

   public function unfollowUrl()
   {
      return UrlHelper::actionUrl('follow/element/unfollow');
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
      return Follow::getInstance()->elementService->followersTotal($elementId);
   }

   /*
      Requests
   */

}
