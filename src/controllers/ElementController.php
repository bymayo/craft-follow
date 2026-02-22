<?php

namespace bymayo\follow\controllers;

use bymayo\follow\Follow;

use Craft;
use craft\web\Controller;

class ElementController extends Controller
{

    // Public Methods
    // =========================================================================

    public function actionFollow()
    {

      $this->requirePostRequest();
      $this->requireLogin();

      $request = Craft::$app->getRequest();

      $elementId = (int) $request->getRequiredBodyParam('elementId');

      if (Follow::getInstance()->elementService->follow($elementId))
      {
         return $this->redirectToPostedUrl();
      }

      return false;

    }

    public function actionUnfollow()
    {

      $this->requirePostRequest();
      $this->requireLogin();

      $request = Craft::$app->getRequest();

      $elementId = (int) $request->getRequiredBodyParam('elementId');

      if (Follow::getInstance()->elementService->unfollow($elementId))
      {
         return $this->redirectToPostedUrl();
      }

      return false;

   }

}
