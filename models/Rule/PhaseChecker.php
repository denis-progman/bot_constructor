<?php


namespace BotConstructor\Rule;


/**
 * Class PhaseChecker
 * @package BotConstructor\Rule
 */
class PhaseChecker
{
    /**
     * @var string
     */
    protected string $type;

    /**
     * @var string
     */
    protected string $exp;

    /**
     * @var Action
     */
    protected Action $success;

    /**
     * @var RuleError
     */
    protected RuleError $error;

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
     * @return string
     */
    public function getExp(): string
    {
        return $this->exp;
    }

    /**
     * @param string $exp
     */
    public function setExp(string $exp): void
    {
        $this->exp = $exp;
    }

    /**
     * @return Action
     */
    public function getSuccess(): Action
    {
        return $this->success;
    }

    /**
     * @param Action $success
     */
    public function setSuccess(Action $success): void
    {
        $this->success = $success;
    }

    /**
     * @return RuleError
     */
    public function getError(): RuleError
    {
        return $this->error;
    }

    /**
     * @param RuleError $error
     */
    public function setError(RuleError $error): void
    {
        $this->error = $error;
    }


}