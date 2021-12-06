<?php


namespace BotConstructor\Bot;

use BotConstructor\Bot\BotAnswer\CallbackQuery;
use BotConstructor\Bot\BotAnswer\Message;


class BotAnswer
{
    const CALLBACK_ANSWER_TYPE = 'callbackQuery';
    const MESSAGE_ANSWER_TYPE = 'message';

    private int $updateId;

    private ?Message $message  = null;

    private ?CallbackQuery $callbackQuery = null;

    /**
     * @return int
     */
    public function getUpdateId(): int
    {
        return $this->updateId;
    }

    /**
     * @param int $updateId
     */
    public function setUpdateId(int $updateId): void
    {
        $this->updateId = $updateId;
    }

    /**
     * @return ?Message
     */
    public function getMessage(): ?Message
    {
        return $this->message;
    }

    /**
     * @param Message $message
     */
    public function setMessage(Message $message): void
    {
        $this->message = $message;
    }

    /**
     * @return ?CallbackQuery
     */
    public function getCallbackQuery(): ?CallbackQuery
    {
        return $this->callbackQuery;
    }

    /**
     * @param CallbackQuery $callbackQuery
     */
    public function setCallbackQuery(CallbackQuery $callbackQuery): void
    {
        $this->callbackQuery = $callbackQuery;
    }

    /**
     * @return ?string
     */
    public function getAnswerType(): ?string
    {
        if ($this->callbackQuery){
            return self::CALLBACK_ANSWER_TYPE;
        } elseif ($this->message) {
            return self::MESSAGE_ANSWER_TYPE;
        } else {
            return null;
        }
    }

    public function getBody() {
        return $this->callbackQuery ?? $this->message ?? null;
    }

    public function toArray(): array {
        return (array) $this->getBody();
    }

}
