<?php


namespace BotConstructor;


use BotConstructor\Bot\BotAnswer\CallbackQuery;
use BotConstructor\Bot\BotAnswer\Message;

class Step
{
    private int $id;

    private User $user;

    private string $date;

    private Rule $rule;

    private Message $message;

    private CallbackQuery $CallbackQuery;

    private string $saveData;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return Rule
     */
    public function getRule(): Rule
    {
        return $this->rule;
    }

    /**
     * @param Rule $rule
     */
    public function setRule(Rule $rule): void
    {
        $this->rule = $rule;
    }

    /**
     * @return Message
     */
    public function getMessage(): Message
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
     * @return CallbackQuery
     */
    public function getCallbackQuery(): CallbackQuery
    {
        return $this->CallbackQuery;
    }

    /**
     * @param CallbackQuery $CallbackQuery
     */
    public function setCallbackQuery(CallbackQuery $CallbackQuery): void
    {
        $this->CallbackQuery = $CallbackQuery;
    }

    /**
     * @return string
     */
    public function getSaveData(): string
    {
        return $this->saveData;
    }

    /**
     * @param string $saveData
     */
    public function setSaveData(string $saveData): void
    {
        $this->saveData = $saveData;
    }


}