<?php


namespace BotConstructor\Bot\BotAnswer;

use BotConstructor\User;

class Message
{
    private int $messageId;

    private Chat $chat;

    private User $user;



    private int $date;

    private string $text;

    private ReplyMarkup $replyMarkup;

    /**
     * @return int
     */
    public function getMessageId(): int
    {
        return $this->messageId;
    }

    /**
     * @param int $messageId
     */
    public function setMessageId(int $messageId): void
    {
        $this->messageId = $messageId;
    }

    /**
     * @return Chat
     */
    public function getChat(): Chat
    {
        return $this->chat;
    }

    /**
     * @param Chat $chat
     */
    public function setChat(Chat $chat): void
    {
        $this->chat = $chat;
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
     * @return int
     */
    public function getDate(): int
    {
        return $this->date;
    }

    /**
     * @param int $date
     */
    public function setDate(int $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return ReplyMarkup
     */
    public function getReplyMarkup(): ReplyMarkup
    {
        return $this->replyMarkup;
    }

    /**
     * @param ReplyMarkup $replyMarkup
     */
    public function setReplyMarkup(ReplyMarkup $replyMarkup): void
    {
        $this->replyMarkup = $replyMarkup;
    }

}