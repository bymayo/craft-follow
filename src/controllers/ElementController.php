<?php

namespace bymayo\follow\controllers;

use bymayo\follow\Follow;

use Craft;
use craft\web\Controller;

class ElementController extends Controller
{

    // Protected Properties
    // =========================================================================

    protected array|int|bool $allowAnonymous = ['follow', 'unfollow'];

    // Public Methods
    // =========================================================================

    public function actionFollow()
    {

      $request = Craft::$app->getRequest();

      $elementId = $request->getParam('elementId');
      $redirect = $request->getParam('redirect');

      if (Follow::getInstance()->elementService->follow($elementId))
      {
         return $this->redirect($redirect ?? Craft::$app->getRequest()->referrer);
      }

      return false;

    }

    public function actionUnfollow()
    {

      $request = Craft::$app->getRequest();

      $elementId = $request->getParam('elementId');
      $redirect = $request->getParam('redirect');

      if (Follow::getInstance()->elementService->unfollow($elementId))
      {
         return $this->redirect($redirect ?? Craft::$app->getRequest()->referrer);
      }

      return false;

   }

}
