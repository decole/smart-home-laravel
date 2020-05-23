<?php


namespace App\Services\ValidateDevices;

interface DeviceInterface
{

    /**
     * Передача массива топиков
     * @return array
     */
    public function getTopics();

    /**
     * Создание кэшированных данных
     * @return array
     */
    public function createDataset();

    /**
     * Анализ приходящих сообщений на вхождение в допустимые прределы**
     * @param $message
     * @return mixed
     */
    public function deviceValidate($message);

}
