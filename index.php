<?php
#отключение php ошибок
ini_set('error_reporting', 0);
ini_set('display_errors', 0);
ini_set('display_startup_errors', -1);


/*
 * @c1 @c2 => (integer) номер комманды от 0 и выше, обязательно integer, даже '0' - нельзя
 * return array(количество голов которая забила 1ая комманда, количество голов которая забила2ая комманда);
 * */
function match($c1, $c2){

    $array_errors = array('errors' => []);

    try{
        if (
            !isset($c1) || !is_int($c1)
            || !isset($c2) || !is_int($c2)
        ){
            throw new Exception('Не верные входные данные для расчета. Обратитесь к администратору');
        }

        $file_autoload = 'auto_load.php'; #файл с автозагрузкой необходимых для работы приложения

        if (!file_exists($file_autoload)){

            throw new Exception('Произошла ошибка во время подключения файлов в index.php :'. $file_autoload);
        };

        require_once($file_autoload);

        if (!isset($mirafox)){

            throw new Exception('Произошла ошибка в подключаемых файлах. Обратитьесь к администратору');
        }

        $result = $mirafox->parser->run_app($c1, $c2);

        if (gettype ($result) == 'array'
            && isset($result[0]) && isset($result[1])
            && is_int($result[0]) && is_int($result[1])
        ){

            return $result;
        }else{
            
            throw new Exception(ERRORRESULT);
        }

    }catch(Exception $e){#Все ошибки во время выполнения приложения будут ссылаться сюда

        array_push($array_errors['errors'],$e->getMessage());
        
    }

    return $array_errors;#Можно так же заменить на json_encode(...) для запросов AJAX

}



