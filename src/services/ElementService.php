<?php

namespace bymayo\follow\services;

use bymayo\follow\Follow;
use bymayo\follow\records\ElementsRecord;

use Craft;
use craft\base\Component;
use craft\services\Elements;
use craft\db\Query;

class ElementService extends Component
{

    // Public Methods
    // =========================================================================

    public function arrayToString($array, $key)
    {

      $results = array();

      foreach ($array as $item) {
          array_push($results, $item[$key]);
      }

      return implode(',', $results);

   }

    public function following($params)
    {

      $user = isset($params['userId']) ? Craft::$app->users->getUserById($params['userId']) : Craft::$app->getUser()->getIdentity();
      $elementClass = isset($params['elementClass']) ? $params['elementClass'] : 'craft\elements\User';

      try {

         $query = (new Query())
            ->select(['elementId'])
            ->from(['{{%follow_elements}}'])
            ->where([
               'userId' => $user->id,
               'elementClass' => $elementClass
            ])
            ->limit(null);

         $command = $query->createCommand();
         $queryResult = $command->queryAll();

         return $this->arrayToString($queryResult, 'elementId');

      }
      catch (Exception $e) {
         throw $e;
      }

   }

   public function followers($elementId)
   {

      $elementId = $elementId ?? Craft::$app->getUser()->getIdentity()->id;

      try {

         $query = (new Query())
            ->select(['userId'])
            ->from(['{{%follow_elements}}'])
            ->where([
               'elementId' => $elementId
            ])
            ->limit(null);

         $command = $query->createCommand();
         $queryResult = $command->queryAll();

         $results = array();

         foreach ($queryResult as $result) {
            array_push($results, $result['userId']);
         }

         return $this->arrayToString($queryResult, 'userId');

      }
      catch (Exception $e) {
         throw $e;
      }

   }

    public function check($elementId, $userId)
    {

      $user = is_null($userId) ? Craft::$app->getUser()->getIdentity() : Craft::$app->users->getUserById($userId);

      $elementRecord = ElementsRecord::findOne(
          [
            'userId' => $user->id,
            'elementId' => $elementId
          ]
      );

      return $elementRecord ? true : false;
   }

    public function follow($elementId)
    {

      $user = Craft::$app->getUser()->getIdentity();

      $elementRecord = ElementsRecord::findOne(
          [
             'userId' => $user->id,
             'elementId' => $elementId
          ]
      );

      if (!$elementRecord && $user) {

         $elementClass = Craft::$app->getElements()->getElementTypeById($elementId);

         // To stop people following ID's of classes that aren't allowed if they know the ID
         if (in_array($elementClass, Follow::$plugin->getSettings()->allowedElementClasses))
         {

            $elementRecord = new ElementsRecord();

            $elementRecord->userId = $user->id;
            $elementRecord->elementId = $elementId;
            $elementRecord->elementClass = $elementClass;
            $elementRecord->siteId = Craft::$app->getSites()->currentSite->id;

            $db = Craft::$app->getDb();
            $transaction = $db->beginTransaction();

            try {

                $success = $elementRecord->save(false);

                if ($success) {
                    $transaction->commit();
                }

            }
            catch (\Throwable $e) {

                $transaction->rollBack();
                throw $e;

            }

            return true;

         }

      }

      return false;

    }

   public function unfollow($elementId)
   {

      $user = Craft::$app->getUser()->getIdentity();

      $elementRecord = ElementsRecord::findOne(
         [
            'userId' => $user->id,
            'elementId' => $elementId
         ]
      );

      if ($elementRecord) {

          $elementRecord->delete();
          return true;

      }

      return false;

   }

}