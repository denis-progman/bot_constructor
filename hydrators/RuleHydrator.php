<?php


namespace BotConstructor\Rule;

use BotConstructor\core\MainHydrator;
use BotConstructor\Rule;

class RuleHydrator extends MainHydrator
{
    const FULL_NAMES_CLASSES = "BotConstructor\\Rule\\";

    private ?Rule $ruleObject = null;

    /**
     * @return Rule|null
     */
    public function getRuleObject(): ?Rule
    {
        return $this->ruleObject;
    }

    /**
     * @param Rule|null $ruleObject
     */
    public function setRuleObject(?Rule $ruleObject): void
    {
        $this->ruleObject = $ruleObject;
    }

}