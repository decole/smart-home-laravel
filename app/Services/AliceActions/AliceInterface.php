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
     * Слова тригеры и их процессы
     * @param $message
     * @return void
     */
    public function verb($message);

}
