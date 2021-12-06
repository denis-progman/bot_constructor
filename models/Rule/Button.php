<?php
namespace BotConstructor\Rule;

use BotConstructor\Rule\Action;

/**
 * Class Button
 * @package BotConstructor\Rule
 */
class Button
{
    /**
     * @var string
     */
    protected string $name;

    /**
     * @var Action
     */
    protected Action $action;

    /**
     * @var string
     */
    protected string $type;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return \BotConstructor\Rule\Action
     */
    public function getAction(): \BotConstructor\Rule\Action
    {
        return $this->action;
    }

    /**
     * @param \BotConstructor\Rule\Action $action
     */
    public function setAction(\BotConstructor\Rule\Action $action): void
    {
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }



}