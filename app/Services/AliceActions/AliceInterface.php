<?php


namespace App\Services\AliceActions;

interface AliceInterface
{
    /**
     * @return mixed
     */
    public function listVerb();

    /**
     * Главный метод вывода данных по диалогу
     * @param $message
     * @return mixed
     */
    public function process($message);

    /**
     * Генерация ответа
     * @param $message
     * @return mixed
     */
    public function verb($message);

}
