<?php


namespace BotConstructor;

use BotConstructor\Rule\Action;
use BotConstructor\Rule\Button;
use BotConstructor\Rule\Content;
use BotConstructor\Rule\Note;

class Rule
{
    /**
     * @var string
     */
    protected string $rulesFile;

    /**
     * @var string|null
     */
    protected ?string $previousFile;

    /**
     * @var string|null
     */
    protected ?string $nextRulesFile;

    /**
     * @var int
     */
    protected int $ruleKey;

    /**
     * @var int|null
     */
    protected ?int $previousKey;

    /**
     * @var int|null
     */
    protected ?int $nextKey;

    /**
     * @var int|null
     */
    protected ?int $subRuleKey;

    /**
     * @var int|null
     */
    protected ?int $previousSubKey;

    /**
     * @var int|null
     */
    protected ?int $nextSubKey;

    /**
     * @var string|null
     */
    protected ?string $text;

    /**
     * @var Button|null
     */
    protected ?Button $button;

    /**
     * @var Button[]|null
     */
    protected ?array $buttons;

    /**
     * @var Action|null
     */
    protected ?Action $action;

    /**
     * @var Action[]|null
     */
    protected ?array $actions;

    /**
     * @var Content|null
     */
    protected ?Content $content;

    /**
     * @var Note|null
     */
    protected ?Note $note;

    /**
     * @return string
     */
    public function getRulesFile(): string
    {
        return $this->rulesFile;
    }

    /**
     * @param string $rulesFile
     */
    public function setRulesFile(string $rulesFile): void
    {
        $this->rulesFile = $rulesFile;
    }

    /**
     * @return string|null
     */
    public function getPreviousFile(): ?string
    {
        return $this->previousFile;
    }

    /**
     * @param string|null $previousFile
     */
    public function setPreviousFile(?string $previousFile): void
    {
        $this->previousFile = $previousFile;
    }

    /**
     * @param string|null $nextRulesFile
     */
    public function setNextRulesFile(?string $nextRulesFile): void
    {
        $this->nextRulesFile = $nextRulesFile;
    }

    /**
     * @return string|null
     */
    public function getNextRulesFile(): ?string
    {
        return $this->nextRulesFile;
    }

    /**
     * @return int
     */
    public function getRuleKey(): int
    {
        return $this->ruleKey;
    }

    /**
     * @param int $ruleKey
     */
    public function setRuleKey(int $ruleKey): void
    {
        $this->ruleKey = $ruleKey;
    }

    /**
     * @return int|null
     */
    public function getPreviousKey(): ?int
    {
        return $this->previousKey;
    }

    /**
     * @param int|null $previousKey
     */
    public function setPreviousKey(?int $previousKey): void
    {
        $this->previousKey = $previousKey;
    }

    /**
     * @param int|null $nextKey
     */
    public function setNextKey(?int $nextKey): void
    {
        $this->nextKey = $nextKey;
    }

    /**
     * @return int|null
     */
    public function getNextKey(): ?int
    {
        return $this->nextKey;
    }

    /**
     * @return int|null
     */
    public function getSubRuleKey(): ?int
    {
        return $this->subRuleKey;
    }

    /**
     * @param int|null $subRuleKey
     */
    public function setSubRuleKey(?int $subRuleKey): void
    {
        $this->subRuleKey = $subRuleKey;
    }

    /**
     * @return int|null
     */
    public function getPreviousSubKey(): ?int
    {
        return $this->previousSubKey;
    }

    /**
     * @param int|null $previousSubKey
     */
    public function setPreviousSubKey(?int $previousSubKey): void
    {
        $this->previousSubKey = $previousSubKey;
    }

    /**
     * @param int|null $nextSubKey
     */
    public function setNextSubKey(?int $nextSubKey): void
    {
        $this->nextSubKey = $nextSubKey;
    }

    /**
     * @return int|null
     */
    public function getNextSubKey(): ?int
    {
        return $this->nextSubKey;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     */
    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return Button|null
     */
    public function getButton(): ?Button
    {
        return $this->button;
    }

    /**
     * @param Button|null $button
     */
    public function setButton(?Button $button): void
    {
        $this->buttons = $button;
    }

    /**
     * @return Button[]|null
     */
    public function getButtons(): ?array
    {
        if ($this->buttons && !empty($this->buttons)) {
            return $this->buttons;
        }
        if ($this->button) {
            return [$this->button];
        }
        return null;
    }

    /**
     * @param Button[]|null $buttons
     */
    public function setButtons(array $buttons): void
    {
        $this->buttons = $buttons;
    }


    /**
     * @return Action|null
     */
    public function getAction(): ?Action
    {
        return $this->action;
    }

    /**
     * @param Action|null $action
     */
    public function setAction(?Action $action): void
    {
        $this->buttons = $action;
    }

    /**
     * @return Action[]|null
     */
    public function getActions(): ?array
    {
        if ($this->actions && !empty($this->actions)) {
            return $this->actions;
        }
        if ($this->action) {
            return [$this->action];
        }
        return null;
    }

    /**
     * @param Action[]|null $actions
     */
    public function setActions(array $actions): void
    {
        $this->actions = $actions;
    }

    /**
     * @return Content|null
     */
    public function getContent(): ?Content
    {
        return $this->content;
    }

    /**
     * @param Content|null $content
     */
    public function setContent(?Content $content): void
    {
        $this->content = $content;
    }

    /**
     * @return Note|null
     */
    public function getNote(): ?Note
    {
        return $this->note;
    }

    /**
     * @param Note|null $note
     */
    public function setNote(?Note $note): void
    {
        $this->note = $note;
    }


}