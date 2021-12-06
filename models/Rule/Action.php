<?php


namespace BotConstructor\Rule;


/**
 * Class Action
 * @package BotConstructor\Rule
 */
class Action
{
    /**
     * @var string
     */
    protected string $type;

    /**
     * @var string|null
     */
    protected ?string $target = null;

    /**
     * @var Action|null
     */
    protected ?Action $afterAction;

    /**
     * @var int|null
     */
    protected ?int $delay;

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

    /**
     * @return string|null
     */
    public function getTarget(): ?string
    {
        return $this->target;
    }

    /**
     * @param string|null $target
     */
    public function setTarget(?string $target): void
    {
        $this->target = $target;
    }

    /**
     * @return Action|null
     */
    public function getAfterAction(): ?Action
    {
        return $this->afterAction;
    }

    /**
     * @param Action|null $afterAction
     */
    public function setAfterAction(?Action $afterAction): void
    {
        $this->afterAction = $afterAction;
    }

    /**
     * @return int|null
     */
    public function getDelay(): ?int
    {
        return $this->delay;
    }

    /**
     * @param int|null $delay
     */
    public function setDelay(?int $delay): void
    {
        $this->delay = $delay;
    }

}