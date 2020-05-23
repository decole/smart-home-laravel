<?php
/**
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\UserCommands;


use App\Schedule;
use App\Services\WateringService;
use DateTime;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\TelegramLog;

/**
 * User "/weather" command
 *
 * Get weather info for any place.
 * This command requires an API key to be set via command config.
 */
class DiagnosticCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'diagnostic';

    /**
     * @var string
     */
    protected $description = 'Запуск самодиагностики умного дома и внутренних систем';

    /**
     * @var string
     */
    protected $usage = '/diagnostic';

    /**
     * @var string
     */
    protected $version = '0.0.1';

    /**
     * Command execute method
     *
     * @return \Longman\TelegramBot\Entities\ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute()
    {
        $message      = $this->getMessage();
        $chat_id      = $message->getChat()->getId();

        /** @var Schedule $model */
        $model = Schedule::find(12);
        $lastRunDate = new DateTime('NOW');
        $model->next_run = $lastRunDate->format('Y-m-d H:i:00');
        $model->interval = null;
        $model->save();

        $data = [
            'chat_id' => $chat_id,
            'text'    => 'Самодиагностика запланирована в менеджере задач',
        ];

        return Request::sendMessage($data);
    }
}
