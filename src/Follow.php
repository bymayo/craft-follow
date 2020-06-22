<?php

namespace bymayo\follow;

use bymayo\follow\services\FollowService;
use bymayo\follow\variables\FollowVariable;
use bymayo\follow\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

class Follow extends Plugin
{
    // Static Properties
    // =========================================================================

    public static $plugin;

    // Public Properties
    // =========================================================================

    public $schemaVersion = '1.0.1';

    public $hasCpSettings = false;

    // Public Methods
    // =========================================================================

    public function init()
    {

        parent::init();
        self::$plugin = $this;

        $this->setComponents([
            'elementService' => \bymayo\follow\services\ElementService::class,
            'requestService' => \bymayo\follow\services\RequestService::class,
            'notificationService' => \bymayo\follow\services\NotificationService::class
         ]);

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                $variable = $event->sender;
                $variable->set('follow', FollowVariable::class);
            }
        );

        Craft::info(
            Craft::t(
                'follow',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );

    }

    // Protected Methods
    // =========================================================================

    protected function createSettingsModel()
    {
        return new Settings();
    }

}
