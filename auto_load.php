<?php

/*
 * Файл auto_load.php -> предназначен для подгрузки файлов по умолчанию
 * Запускать файл обязательно в структуре try catch
 *
 * Разработчик А.А. Валиев GravRnD@yandex.ru
 * */

$mirafox = new AutoLoad();# названа mirafox - под название приложения

class AutoLoad {

    function __construct() {
        if (!isset($array_errors)) $array_errors = [];

        $file_config = 'config.php'; #файл с конфигурациями приложения
        if (!file_exists($file_config)){
            throw new Exception('Произошла ошибка во время подключения файлов в autoload.php :'. $file_config);
        };

        require_once($file_config);

        if (!isset($config) || gettype($config) != 'array'
            || !isset($config['auto_load_files']) || gettype($config['auto_load_files']) != 'array'
        ){
            throw new Exception('Произошла ошибка во время работы с конфигурационным файлом config.php');
        }

        #Подключаем файлы из конфигурации
        foreach ($config['auto_load_files'] as $key => $value) {
            if (!file_exists($value)){
                throw new Exception('Произошла ошибка во время подгрузки файла '.$value);
            };

            require_once($value);
        }

        #Проверка наличия данных от mirafox
        if (!isset($data) || gettype($data) != 'array'){
            throw new Exception('Данные отсутствуют' );
        }

        $this->parser = new ParseData($data);

    }

}