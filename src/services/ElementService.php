<?php

namespace bymayo\follow\services;

use bymayo\follow\Follow;
use bymayo\follow\records\ElementsRecord;

use Craft;
use craft\base\Component;
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

   public function followingTotal($params)
   {

      $user = isset($params['userId']) ? Craft::$app->users->getUserById($params['userId']) : Craft::$app->getUser()->getIdentity();
      $elementClass = isset($params['elementClass']) ? $params['elementClass'] : 'craft\elements\User';

      return (new Query())
         ->from(['{{%follow_elements}}'])
         ->where([
            'userId' => $user->id,
            'elementClass' => $elementClass
         ])
         ->count();

   }

   public function followersTotal($elementId)
   {

      $elementId = $elementId ?? Craft::$app->getUser()->getIdentity()->id;

      return (new Query())
         ->from(['{{%follow_elements}}'])
         ->where([
            'elementId' => $elementId
         ])
         ->count();

   }

    public function following($params)
    {

      $user = isset($params['userId']) ? Craft::$app->users->getUserById($params['userId']) : Craft::$app->getUser()->getIdentity();
      $elementClass = isset($params['elementClass']) ? $params['elementClass'] : 'craft\elements\User';
      $output = isset($params['output']) ? $params['output'] : 'string';

      $query = (new Query())
         ->select(['elementId'])
         ->from(['{{%follow_elements}}'])
         ->where([
            'userId' => $user->id,
            'elementClass' => $elementClass
         ]);

      $queryResult = $query->all();

      return $output == 'array' ? $queryResult : $this->arrayToString($queryResult, 'elementId');

   }

   public function followers($elementId, $output = null)
   {

      $elementId = $elementId ?? Craft::$app->getUser()->getIdentity()->id;
      $output = isset($output) ? $output: 'string';

      $query = (new Query())
         ->select(['userId'])
         ->from(['{{%follow_elements}}'])
         ->where([
            'elementId' => $elementId
         ]);

      $queryResult = $query->all();

      return $output == 'array' ? $queryResult : $this->arrayToString($queryResult, 'userId');

   }

   public function createFollow($elementId)
   {

      $elementClass = Craft::$app->getElements()->getElementTypeById($elementId);

      if (!$this->check(array('elementId' => $elementId)) && in_array($elementClass, Follow::$plugin->getSettings()->allowedElementClasses))
      {

         $elementRecord = new ElementsRecord();

         $elementRecord->userId = Craft::$app->getUser()->getIdentity()->id;
         $elementRecord->elementId = $elementId;
         $elementRecord->elementClass = $elementClass;
         $elementRecord->siteId = Craft::$app->getSites()->currentSite->id;

         $db = Craft::$app->getDb();
         $transaction = $db->beginTransaction();

         try {

            $success = $elementRecord->save(false);

            if ($success) {
               $transaction->commit();
               return true;
            }

            $transaction->rollBack();
            return false;

         }
         catch (\Throwable $e) {

            $transaction->rollBack();
            throw $e;

         }

      }

      return false;

   }

   public function deleteFollow($elementId)
   {

      if ($this->check(array('elementId' => $elementId)))
      {

         $elementRecord = ElementsRecord::findOne(
            [
               'userId' => Craft::$app->getUser()->getIdentity()->id,
               'elementId' => $elementId
            ]
         );

         if ($elementRecord === null) {
            return false;
         }

         $elementRecord->delete();
         return true;

      }

      return false;

   }

   public function check(array $params)
   {

      $user = isset($params['userId']) ? Craft::$app->users->getUserById($params['userId']) : Craft::$app->getUser()->getIdentity();

      return ElementsRecord::find()
         ->where([
            'userId' => $user->id,
            'elementId' => $params['elementId']
         ])
         ->exists();
   }

    public function follow($elementId)
    {

         if (Follow::$plugin->getSettings()->userRequests)
         {
            return Follow::getInstance()->requestService->createRequest($elementId);
         }

         return $this->createFollow($elementId);

   }

   public function unfollow($elementId)
   {

      return $this->deleteFollow($elementId);

   }

   public function toggle($elementId)
   {

      if($this->check(array('elementId' => $elementId)))
      {
         $this->deleteFollow($elementId);
      }
      else
      {
         $this->createFollow($elementId);
      }

   }

}
