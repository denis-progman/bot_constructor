<?php


namespace BotConstructor\Bot\BotAnswer;


use BotConstructor\User;

class CallbackQuery
{
    private int $id;

    private User $user;

    private Message $message;

    private int $chatInstance;

    private string $data;

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
     * @return int
     */
    public function getChatInstance(): int
    {
        return $this->chatInstance;
    }

    /**
     * @param int $chatInstance
     */
    public function setChatInstance(int $chatInstance): void
    {
        $this->chatInstance = $chatInstance;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData(string $data): void
    {
        $this->data = $data;
    }


}