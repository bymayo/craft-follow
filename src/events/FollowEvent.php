<?php

namespace bymayo\follow\events;

use yii\base\Event;

class FollowEvent extends Event
{
    public int $userId;

    public int $elementId;

    public string $elementClass;
}
