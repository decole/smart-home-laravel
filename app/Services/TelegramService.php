<?php


namespace App\Services;


use GuzzleHttp\Client;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;

class TelegramService extends BaseController
{
    private $bot_username;
    private $token;
    public  $telegram;
    public  $users;
    private $commands_paths;
    private $admin_users;
    private $mysql_credentials;
    private $hookUrl;

    /**
     * TelegramHelper constructor.
     *
     * https://github.com/php-telegram-bot/core/issues/822
     *
     * ```
     *
     *  $telegram = new Telegram(...);
     *  ...
     *  Request::setClient(new Client([
     *      'base_uri' => 'https://api.telegram.org',
     *      'proxy'    => 'socks5://127.0.0.1:9050',
     *  ]));
     *  ...
     *  $telegram->handle();
     *
     * ```
     */
    public function __construct()
    {
        $this->hookUrl = env('TELEGRAM_HOOK_URL');
        $this->bot_username = env('TELEGRAM_BOT_NAME');
        $this->token = env('TELEGRAM_BOT_TOKEN');
        $this->users = [
            'decole' => env('DECOLE_TELEGRAM_ID'),
            'panterka' => env('PANTERKA_TELEGRAM_ID'),
        ];
        $this->admin_users = [
            env('DECOLE_TELEGRAM_ID'), // Decole
        ];
        $this->commands_paths = [
            __DIR__ . '/../TelegramCommands/',
        ];
        $this->mysql_credentials = [
            'host'     => env('DB_HOST'),
            'user'     => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'database' => env('DB_DATABASE'),
        ];

        try {
            $this->telegram = new Telegram($this->token, $this->bot_username);
            Request::setClient(new Client([
                'base_uri' => 'https://api.telegram.org',
                'proxy'   => env('SOCKS5_PROXY_TELEGRAM')
            ]));
        } catch (TelegramException $e) {
            $this->telegram = false;
        }

    }

    /**
     * Using on commands and controllers
     *
     * @param $text
     * @param $chatId
     * @return mixed
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function send($text, $chatId)
    {
        try {
            return Request::sendMessage([
                'chat_id' => $chatId,
                'text'    => $text,
            ]);
        } catch (TelegramException $e) {
            return $e;
        }
    }

    /**
     * Send by specific user
     *
     * @param $text
     * @param string $user
     * @return bool|mixed
     * @throws TelegramException
     */
    public function sendByUser($text, $user = 'decole')
    {
        if(empty($this->users[$user])) {
            return false;
        }

        return $this->send($text, $this->users[$user]);

    }

    /**
     * Sending by Decole
     *
     * @param $text
     * @param string $user
     * @return bool
     * @throws TelegramException
     */
    public function sendDecole($text, $user = 'decole')
    {
        return $this->sendByUser($text, $user);

    }

    /**
     * @throws TelegramException
     */
    public function getUpdates()
    {
        try {
            /** @var Telegram $telegram */
            $telegram = $this->telegram;
            $telegram->setCommandConfig('weather', ['owm_api_key' => 'hoArfRosT1215']);
            $telegram->addCommandsPaths($this->commands_paths);
            $telegram->enableAdmins($this->admin_users);
            $telegram->useGetUpdatesWithoutDatabase();
            $telegram->enableLimiter();
            $server_response = $telegram->handleGetUpdates();
            if ($server_response->isOk()) {
//                $update_count = count($server_response->getResult());
//                Log::channel('telegramBot')->info(
//                    date('Y-m-d H:i:s', time())
//                    . ' - Processed '
//                    . $update_count
//                    . ' updates'
//                );
            } else {
                Log::channel('telegramBot')->info($server_response->printError());
            }
        } catch (TelegramException $e) {
            echo $e->getMessage();
        }
    }
}
