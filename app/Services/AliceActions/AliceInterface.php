<?php


namespace App\Services\AliceActions;

interface AliceInterface
{

    /**
     * Главный метод вывода данных по диалогу
     * @param $message
     * @return mixed
     */
    public function process($message);

}
