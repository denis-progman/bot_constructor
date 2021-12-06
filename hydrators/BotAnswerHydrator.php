<?php


namespace BotConstructor\Bot\BotAnswer;

use BotConstructor\Bot\BotAnswer;
use BotConstructor\core\MainHydrator;

class BotAnswerHydrator extends MainHydrator
{
    const NAMESPACE_CLASSES = "BotConstructor\\Bot\\BotAnswer\\";

    const FULL_NAMES_CLASSES = [
        "BotConstructor\\User"
    ];

    const PARAMS_MAPPER = [
        'From' => 'User'
    ];

    private ?BotAnswer $botAnswerObject = null;

    /**
     * @return BotAnswer
     */
    public function getBotAnswerObject(): BotAnswer
    {
        return $this->botAnswerObject;
    }

    /**
     * @param BotAnswer $botAnswerObject
     */
    public function setBotAnswerObject(BotAnswer $botAnswerObject): void
    {
        $this->botAnswerObject = $botAnswerObject;
    }

}