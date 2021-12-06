<?php


namespace BotConstructor;

use BotConstructor\Bot\BotAnswer;
use botConstructor\Bot\BotAnswerService;
use BotConstructor\core\Loger;
use BotConstructor\core\ModelFather;
use BotConstructor\Rule\Button;

class Bot extends ModelFather
{
    const API_URL = "https://api.telegram.org/bot";
    const WEB_HOOK_METHOD = 'setWebhook';
    const SEND_MESSAGE_METHOD = 'sendMessage';
    const BUTTONS_TYPES = [
        'inline',
        'bottom'
    ];


    protected string $botToken;

    protected ?string $input;
    protected ?string $sendMethod;
    protected ?int $targetChatId;
    protected ?BotAnswer $botAnswer;
    protected ?string $inlineButtons = null;
    protected ?string $bottomButtons;
    protected array $sendFiles = [];
    protected string $messageText;
    protected array $requestData = [];
    protected string $get_prefix;
    private string $requestResult;

    /**
     * @throws \Exception
     */
    public function __construct(?int $chatId = null/*, bool $inlineKeyboard = true*/)
    {
        $this->botToken = self::$config['token'];
        $this->input = file_get_contents('php://input') ?? null;
        $this->botAnswer = $this->input ? (new BotAnswerService())->setBotAnswer($this->input)->getBotAnswer() : null;
//        @$this->targetChatId = $chatId ?? (
//            $this->botAnswer ? (
//                $this->botAnswer->getMessage() ?
//                    $this->botAnswer->getMessage()->getChat()->getId() : $this->botAnswer->getCallbackQuery()->getMessage()->getChat()->getId())
//                : null);
        $this->sendMethod = self::SEND_MESSAGE_METHOD;
        $this->get_prefix = self::$config['get_prefix'];

//        $this->inlineKeyboard = $inlineKeyboard;
    }

    /**
     * @return BotAnswer|null
     */
    public function getBotAnswer(): ?BotAnswer
    {
        return $this->botAnswer;
    }

    /**
     * @param BotAnswer|null $botAnswer
     */
    public function setBotAnswer(?BotAnswer $botAnswer): void
    {
        $this->botAnswer = $botAnswer;
    }

    /**
     * @return string
     */
    public function getRequestResult(): string
    {
        return $this->requestResult;
    }

    /**
     * @param string $requestResult
     */
    public function setRequestResult(string $requestResult): void
    {
        $this->requestResult = $requestResult;
    }

    /**
     * @return string
     */
    public function getMessageText(): string
    {
        return $this->messageText;
    }

    /**
     * @param string $messageText
     */
    public function setMessageText(string $messageText): void
    {
        $this->messageText = $messageText;
    }

    /**
     * @return array
     */
    public function getRequestData(): array
    {
        return $this->requestData;
    }

    /**
     * @param array $requestData
     */
    public function setRequestData(array $requestData): void
    {
        $this->requestData = $requestData;
    }

    /**
     * @return string|null
     */
    public function getSendMethod(): ?string
    {
        return $this->sendMethod;
    }

    /**
     * @param string|null $sendMethod
     */
    public function setSendMethod(?string $sendMethod): void
    {
        $this->sendMethod = $sendMethod;
    }

    /**
     * @return array|null
     */
    private function getInputData(): ?array
    {
        return json_decode($this->input, true);
    }

    /**
     * @return string|null
     */
    public function getInlineButtons(): ?string
    {
        return $this->inlineButtons;
    }


    protected function sendRequest(): ?string
    {
        try {
            $ch = curl_init();
            if (!empty($this->sendFiles)) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $urlRequest = self::API_URL . $this->botToken . '/' . $this->sendMethod;
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getRequestData());
            curl_setopt($ch, CURLOPT_URL, $urlRequest);
            $this->requestResult =  curl_exec($ch);
            curl_close($ch);
            if (!@$this->requestResult) {
                throw new \Exception("Empty answer!");
            }
            $result = json_decode($this->requestResult, true);
            if (@!$result['ok']) {
                throw new \Exception($result['description']);
            }
            return $this->requestResult;
        } catch (\Throwable $e) {
            print_r($e->getMessage());
            print_r($this->getRequestData());
            Loger::log($e->getMessage(), Loger::ERROR_LEVEL);
            return false;
        }

    }

    public function sendMessage(string $message): bool
    {
        $this->setSendMethod(__FUNCTION__);
        $data = [
            'text' => $message,
            'chat_id' => $this->targetChatId,
        ];
        if ($this->inlineButtons) {
            $data['reply_markup'] = $this->inlineButtons;
        }
        $this->setRequestData($data);
        return $this->sendRequest();
    }

    public function sendChatAction(string $action = 'typing'): bool
    {
        $this->setSendMethod(__FUNCTION__);
        $data = [
            'action' => $action,
            'chat_id' => $this->targetChatId,
        ];
        $this->setRequestData($data);
        return $this->sendRequest();
    }
    public function answerCallbackQuery($text, $show_alert = false, $cacheTime = 30): bool
    {
        $this->setSendMethod(__FUNCTION__);
        $data = [
            'callback_query_id' => $this->botAnswer->getCallbackQuery()->getId(),
            'text' => $text,
            'show_alert' => $show_alert,
            'cache_time' => $cacheTime,
        ];
        $this->setRequestData($data);
        return $this->sendRequest();
    }

    public function setHook(): bool
    {
        $this->setSendMethod(self::WEB_HOOK_METHOD);
        $url = "{$_SERVER['HTTP_X_FORWARDED_PROTO']}://{$_SERVER['HTTP_HOST']}" . explode('?', $_SERVER['REQUEST_URI'])[0];
        $this->setRequestData([
            'url' => $url . ($this->get_prefix?('?' . $this->get_prefix):''),
        ]);
        $result = json_decode($this->sendRequest(), true);
        Loger::log($result, Loger::LOG_LEVEL);
        if ($result['ok']) {
            return print_r(
                "setting webhook for url: {$this->requestData['url']}. result: {$result['description']}, {$result['description']}"
            );
        }
        return false;
    }

    /**
     * создаем кнопки
     * @param Button[] $buttons
     * @throws \Exception
     */
    public function makeButtons(array $buttons)
    {
        $this->inlineButtons = $this->bottomButtons = null;
        foreach ($buttons as $button) {
            if(array_search($buttonType = $button->getType(), self::BUTTONS_TYPES) !== false){
                $this->{"make" . ucfirst($buttonType) . "Buttons"}($button);
                continue;
            }
            throw new \Exception("Error: Unknown button type for Bot: '$buttonType'");
        }
    }

    private function makeInlineButtons(Button $button): void {
        $buttons = json_decode($this->inlineButtons, true);
        if (!isset($buttons['inline_keyboard'])) {
            $buttons['inline_keyboard'] = [];
        };
        $buttons['inline_keyboard'][] = [
                ['text' => $button->getName(), 'callback_data' => $button->getAction()->getTarget()?:' '],
        ];
        $this->inlineButtons = json_encode($buttons, JSON_UNESCAPED_UNICODE);
    }





//
//    public function init($answers = null, $sms_data = null, $parse_mode = null, $file = null, $extra_data = null)
//    {
//        // создаем массив из пришедших данных от API Telegram
//        $arrData = $this->getData();
//
//        // лог
//        // $this->setFileLog($arrData);
//
//        if (array_key_exists('message', $arrData)) {
//            $chat_id = $arrData['message']['chat']['id'];
//            $message = $arrData['message']['text'];
//
//        } elseif (array_key_exists('channel_post', $arrData)) {
//            $chat_id = $arrData['channel_post']['chat']['id'];
//            $message = $arrData['channel_post']['text'];
//        } elseif (array_key_exists('callback_query', $arrData)) {
//            $chat_id = $arrData['callback_query']['message']['chat']['id'];
//            $message = $arrData['callback_query']['data'];
//        }
//
//        if ($this->specified_chat_id)
//            $chat_id = $this->specified_chat_id;
//
//        $justKeyboard = $this->getKeyBoard([[["text" => "Голосовать_"], ["text" => "Помощь_"]]]);
//
//        $inlineKeyboard = $this->getInlineKeyBoard([[
//            ['text' => hex2bin('F09F918D') . ' 0', 'callback_data' => 'vote_1_0_0'],
//            ['text' => hex2bin('F09F918E') . ' 0', 'callback_data' => 'vote_0_0_0']
//        ]]);
//        $is_file = false;
//        if ($sms_data) {
//            switch ($this->send_method) {
//                case 'sendMessage':
//                    $dataSend = array(
//                        'text' => $sms_data,
//                        'chat_id' => $chat_id,
//                    );
//                    $is_file = false;
//                    break;
//                default :
//                    $dataSend = array(
//                        'caption' => $sms_data,
//                        'chat_id' => $chat_id,
//                    );
//                    if ($file) {
//                        $dataSend[strtolower(preg_replace('/^(send)([\w]{3,9})$/i', '$2', $this->send_method, -1, $count))] = new CURLFile(realpath($file));
//                        $is_file = true;
//                    }
//                    break;
//            }
//            if ($this->inline_keyboard && $this->send_method == 'sendAudio')
//                $dataSend['reply_markup'] = $inlineKeyboard;
//
//            if ($parse_mode)
//                $dataSend['parse_mode'] = $parse_mode;
//            if ($extra_data && is_array($extra_data))
//                $dataSend = array_merge($dataSend, $extra_data);
//
//            return $this->requestToTelegram($dataSend, $this->send_method, $is_file);
//        }
//
//        switch ($message) {
//            case '/start_testing':
//                $dataSend = array(
//                    'text' => "Приветствую, давайте начнем нашу практику. Нажмите на кнопку Голосовать.",
//                    'chat_id' => $chat_id,
//                    'reply_markup' => $justKeyboard,
//                );
//                $this->requestToTelegram($dataSend, $this->send_method);
//                break;
//            case 'Голосовать_':
//                $dataSend = array(
//                    'text' => "Выберите один из вариантов",
//                    'chat_id' => $chat_id,
//                    'reply_markup' => $inlineKeyboard,
//                );
//                $this->requestToTelegram($dataSend, $this->send_method);
//                break;
//            case 'Помощь_':
//                $dataSend = array(
//                    'text' => "Просто нажмите на кнопку Голосовать.",
//                    'chat_id' => $chat_id,
//                );
//                $this->requestToTelegram($dataSend, $this->send_method);
//                break;
//            case (preg_match('/^vote/', $message) ? true : false):
//                if (is_array($answers)) {
//                    $params = $this->setParams($message, $answers);
//
//                    $dataSend = array(
//                        'reply_markup' => $params[0],
//                        'message_id' => $arrData['callback_query']['message']['message_id'],
//                        'chat_id' => $chat_id,
//                    );
//                    $this->changeVote($dataSend, $params[1], $arrData['callback_query']['id'], null, isset($answers[2]) ? $answers[2] : null);
//                } else {
//                    $this->changeVote(null, null, $arrData['callback_query']['id'], $answers);
//                }
//                break;
//            default:
//                return false;
////                $dataSend = array(
////                    'text' => "Не запланированная реакция, может просто нажмете на кнопку Голосовать.",
////                    'chat_id' => $chat_id,
////                );
////                $this->requestToTelegram($dataSend, $this -> send_method);
//                break;
//        }
//    }
//
//    /** Меняем клавиатуру Vote
//     * @param $data
//     * @param $emogi
//     * @param $callback_query_id
//     */
//    private function changeVote($data, $emoji, $callback_query_id, $error_text = null, $rait_text = null)
//    {
//        $rait_text = $rait_text ? (" " . $rait_text) : '';
//        if ($error_text) {
//            $text = $error_text;
//        } else {
//            $text = $this->requestToTelegram($data, "editMessageReplyMarkup")
//                ? ("You voted " . hex2bin($emoji) . $rait_text)
//                : "Unexpected error, please try later.";
//        }
//        $this->requestToTelegram([
//            'callback_query_id' => $callback_query_id,
//            'text' => $text,
//            'cache_time' => 30,
//        ], "answerCallbackQuery");
//    }
//
//    /** Устанавливаем новые значения Vote
//     * @param $data
//     * @return string
//     */
//    private function setParams($data, $answers)
//    {
//        $params = explode("_", $data);
//        $params[1] ? $params[2]++ : $params[3]++;
//        $arr[] = $this->getInlineKeyBoard([[
//            ['text' => hex2bin('F09F918D') . ' ' . $answers[0], 'callback_data' => 'vote_1_' . $answers[0] . '_' . $answers[1]],//$params[2] . '_' . $params[3]],
//            ['text' => hex2bin('F09F918E') . ' ' . $answers[1], 'callback_data' => 'vote_0_' . $answers[0] . '_' . $answers[1]] //$params[2] . '_' . $params[3]]
//        ]]);
//        $arr[] = $params[1] ? 'F09F918D' : 'F09F918E';
//        return $arr;
//    }
//
//    /**
//     * создаем inline клавиатуру
//     * @return string
//     */
//    private function getInlineKeyBoard($data)
//    {
//        $inlineKeyboard = array(
//            "inline_keyboard" => $data,
//        );
//        return json_encode($inlineKeyboard);
//    }
//
//    /**
//     * создаем клавиатуру
//     * @return string
//     */
//    private function getKeyBoard($data)
//    {
//        $keyboard = array(
//            "keyboard" => $data,
//            "one_time_keyboard" => false,
//            "resize_keyboard" => true
//        );
//        return json_encode($keyboard);
//    }
//
//
//
//    /** Отправляем запрос в Телеграмм
//     * @param $data
//     * @param string $type
//     * @param bool $is_file
//     * @return mixed
//     */
//    private function requestToTelegram($data, $type, $is_file = false)
//    {
//        if (!$is_file)
//            $this->setFileLog($data);
//        $result = null;
//
//        if (is_array($data)) {
//            $ch = curl_init();
//            if ($is_file)
//                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
//            curl_setopt($ch, CURLOPT_URL, self::API_URL . $this->botToken . '/' . $type);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//            $result = curl_exec($ch);
//            curl_close($ch);
//        }
//        $this->result = $result;
//        $this->setFileLog('  --' . date('h:i d-m-Y') . ' -Result: ' . $result);
//
//        return $result;
//    }
//
//    public function getResult()
//    {
//        return $this->result;
//    }
}