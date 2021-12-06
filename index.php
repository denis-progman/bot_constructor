<?php
require_once 'autoloader.php';
use BotConstructor\Bot;
use BotConstructor\Bot\BotAnswer;
use \BotConstructor\core\Loger;
use \BotConstructor\ORM\DB;
use BotConstructor\Rule\RuleService;
use BotConstructor\Step\StepService;
use BotConstructor\User;
use BotConstructor\User\UserService;

//$db = new DB();
//$dbConnect = $db->getConnection();
//print_r($db->q("show tables"));
echo "<br><br><pre>";
//if (@$_GET['hook_set'] == 'y') {
//    $bot->setHook();
//    exit();
//}
//echo substr(strrchr(User::class, "\\"), 1);
//exit();
//$step = (new StepService(1))->getStep();
//print_r($step);
//exit();
//$user = (new BotConstructor\User\UserService(1))->getUser();
//print_r($user);
//exit();
//$user = (new UserService(1))->getUser();
//print_r($user);
//exit();
//$paramKey= (new RuleService('start:2'))->getRule();
//print_r($rule);
//exit();

try {
    if (@$_GET['get_prefix'] === (include 'app_config.php')['cron']['get_prefix']) {

        exit(date('H:i:s d-m-Y') . " Выполнено!");
    }

    $bot = new Bot();
    $botAnswer = $bot->getBotAnswer();
    Loger::log($botAnswer, Loger::WARNING_LEVEL);
    if ($botAnswer) {
        exit();
    }
    if ($botAnswer) {
        $bot->sendChatAction();
        if ($botAnswer->getAnswerType() == BotAnswer::MESSAGE_ANSWER_TYPE) {
            $rule = (new RuleService('start:2'))->getRule();
            $bot->makeButtons($rule->getButtons());
            $bot->sendMessage("Вы написали: {$botAnswer->getMessage()->getText()}");
            Loger::log($bot->getBotAnswer());
        } elseif ($botAnswer->getAnswerType() == BotAnswer::CALLBACK_ANSWER_TYPE) {
            $bot->answerCallbackQuery("Нажата кнопка: {$botAnswer->getCallbackQuery()->getData()}", true);
            Loger::log($bot->getBotAnswer()->toArray());
        }
        else {
            $bot->sendMessage("Хз.. " . $botAnswer->getAnswerType());

        }
    }

} catch (Throwable $e) {
    Loger::log($e->getMessage() . ' | File: ' . $e->getFile() . '(' . $e->getLine() . ')', Loger::ERROR_LEVEL);
}
