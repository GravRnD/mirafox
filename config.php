<?php
/*
 * Файл подгружаемый в auto_load.php
 * Сюда прописываются все конфигурации приложения
 *
 * Разработчик А.А. Валиев GravRnD@yandex.ru
 * */

$config = [
    'auto_load_files' => [
        'data' => 'data.php',#данные полученные от mirafox
        'errors' => 'config_error_messages.php', #константы сообщений выводимых ошибок
        'parsedata'=> 'parse_data.php',#проверка валидации передоваемых данных
    ],

];

define('ROUNDLIMIT',3);#Округлениче вычеслений до 1000 после запятой
define('MINRAND',0);#Минимальное число в рандоме
