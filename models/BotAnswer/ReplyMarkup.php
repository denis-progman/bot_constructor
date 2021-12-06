<?php
namespace BotConstructor\Bot\BotAnswer;


class ReplyMarkup
{
    private string $inlineKeyboard;

    /**
     * @return string
     */
    public function getInlineKeyboard(): string
    {
        return $this->inlineKeyboard;
    }

    /**
     * @param $inlineKeyboardArray
     */
    public function setInlineKeyboard($inlineKeyboardArray): void
    {
        if (is_array($inlineKeyboardArray)) {
            $this->inlineKeyboard = json_encode($inlineKeyboardArray, JSON_UNESCAPED_UNICODE);
        } else {
            $this->inlineKeyboard = $inlineKeyboardArray;
        }
    }


}