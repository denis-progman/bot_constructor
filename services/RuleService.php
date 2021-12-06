<?php
namespace BotConstructor\Rule;


use BotConstructor\core\MainService;
use BotConstructor\Rule;

class RuleService extends MainService
{
    private const RULES_PATH = 'rules';

    protected ?Rule $rule = null;

    public function __construct(string $ruleUid)
    {
        $this->rule = new Rule();
        $ruleAddress = explode(":", $ruleUid);
        $subStep = null;
        if (isset($ruleAddress[2])) {
            $subStep = $ruleAddress[2];
        }
        $this->setRule($ruleAddress[0], $ruleAddress[1], $subStep);
    }

    private static function getRuleFile($file): array
    {
        $json = file_get_contents(self::RULES_PATH . '/' . $file . '.json');
        return json_decode($json, true);
    }

    /**
     * @throws \Exception
     */
    public function setRule(string $file, int $step, ?int $subStep = null): RuleService
    {
        RuleHydrator::hydrate(
            self::getRuleFile($file)[$step . ($subStep?"-$subStep":"")],
            $this->rule,
            self::getChildClasses()
        );
        return $this;
    }

    /**
     * @return Rule|null
     */
    public function getRule(): ?Rule
    {
        return $this->rule;
    }

}