<?php
namespace botConstructor\Bot;

use BotConstructor\Bot\BotAnswer\BotAnswerHydrator;
use BotConstructor\core\Loger;
use BotConstructor\core\MainService;

class BotAnswerService extends MainService
{
    protected ?BotAnswer $botAnswer = null;

    public function __construct()
    {
        $this->botAnswer = new BotAnswer();
    }

    private static function getBotAnswerData($json): array
    {
        return json_decode($json, true);
    }

    /**
     * @throws \Exception
     */
    public function setBotAnswer(string $json): ?BotAnswerService
    {
        BotAnswerHydrator::hydrate(
            self::getBotAnswerData($json),
            $this->botAnswer
        );
        return $this;
    }

    /**
     * @return BotAnswer|null
     */
    public function getBotAnswer(): ?BotAnswer
    {
        return $this->botAnswer;
    }

}