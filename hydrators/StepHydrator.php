<?php


namespace BotConstructor\Step;

use BotConstructor\Bot\BotAnswer\CallbackQuery;
use BotConstructor\Bot\BotAnswer\Message;
use BotConstructor\core\MainHydrator;
use BotConstructor\Rule;
use BotConstructor\Step;
use BotConstructor\User;

class StepHydrator extends MainHydrator
{
    const FULL_NAMES_CLASSES = [
        User::class,
        Rule::class,
        Message::class,
        CallbackQuery::class
    ];

    private ?Step $stepObject = null;

    /**
     * @return Step|null
     */
    public function getStepObject(): ?Step
    {
        return $this->stepObject;
    }

    /**
     * @param Step|null $stepObject
     */
    public function setStepObject(?Step $stepObject): void
    {
        $this->stepObject = $stepObject;
    }

}