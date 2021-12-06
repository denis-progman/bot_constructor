<?php
// Class file or namespace list
$classes = [

    // core
    ['core/ModelFather', BotConstructor\core\ModelFather::class],
    ['core/Loger', BotConstructor\core\Loger::class],
    ['orm/DB', BotConstructor\orm\DB::class],
    ['orm/Migrator', BotConstructor\orm\Migrator::class],
    ['core/MainHydrator', BotConstructor\core\MainHydrator::class],
    ['core/MainRepository', BotConstructor\core\MainRepository::class],
    ['core/MainService', BotConstructor\core\MainService::class],
    ['core/easy/EasyHelper', BotConstructor\core\easy\EasyHelper::class],

    // Rule
    ['hydrators/RuleHydrator', BotConstructor\Rule\RuleHydrator::class],
    ['services/RuleService', BotConstructor\Rule\RuleService::class],
    ['models/Rule', BotConstructor\Rule::class],
    ['models/Rule/Action', BotConstructor\Rule\Action::class],
    ['models/Rule/Button', BotConstructor\Rule\Button::class],
    ['models/Rule/Content', BotConstructor\Rule\Content::class],
    ['models/Rule/Note', BotConstructor\Rule\Note::class],
    ['models/Rule/PhaseChecker', BotConstructor\Rule\PhaseChecker::class],
    ['models/Rule/RuleError', BotConstructor\Rule\RuleError::class],

    // Bot
    ['hydrators/BotAnswerHydrator', BotConstructor\Bot\BotAnswerHydrator::class],
    ['services/BotAnswerService', BotConstructor\Bot\BotAnswerService::class],
    ['models/Bot', BotConstructor\Bot::class],
    ['models/BotAnswer', BotConstructor\Bot\BotAnswer::class],
    ['models/BotAnswer/Chat', BotConstructor\Bot\BotAnswer\Chat::class],
    ['models/BotAnswer/Message', BotConstructor\Bot\BotAnswer\Message::class],
    ['models/BotAnswer/CallbackQuery', BotConstructor\Bot\BotAnswer\CallbackQuery::class],
    ['models/BotAnswer/ReplyMarkup', BotConstructor\Bot\BotAnswer\ReplyMarkup::class],

    // User
    ['services/UserService', BotConstructor\User\UserService::class],
    ['repositories/UserRepository', BotConstructor\User\UserRepository::class],
    ['models/User', BotConstructor\User::class],

    // Step
    ['models/Step', BotConstructor\Step::class],
    ['services/StepService', BotConstructor\Step\StepService::class],
    ['repositories/StepRepository', BotConstructor\Step\StepRepository::class],
    ['hydrators/StepHydrator', BotConstructor\Step\StepHydrator::class],

];

// Classes auto loader
spl_autoload_register(function () {
    global $classes;

    foreach ($classes as $oneClass) {
        require_once __DIR__ . '/' . $oneClass[0] . '.php';
        $className = substr(
            strstr($oneClass[0], "/"), 1, strlen($oneClass[0])
        );
        if ($oneClass[0] !== 'core/ModelFather' && method_exists($oneClass[1], 'builder')) {
            $oneClass[1]::builder();
        }
    }
});
