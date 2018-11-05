<?php
/*
 * Обязательные файлы для работы с ParseData
 *  - config_error_messages.php
 *  - config.php
 *  - data.php
 *  - auto_load.php
 *
 * Разработчик А.А. Валиев GravRnD@yandex.ru
 * */
class ParseData{

    function __construct($data) {

        $this->data = $data;#Данные переданные от mirafox

        if (gettype( $this->data) != 'array'){
            throw new Exception(ERRORDATAMF);
        }
    }

    /*
     * $c1, $c2 (integer) команда
     * return array(result goals 1 command, result goals 2 command)
     * */
    function run_app($c1, $c2){
        if (
            !isset($c1) || !is_int($c1)
            || !isset($c2) || !is_int($c2)
            || !isset( $this->data[$c1] ) || gettype( $this->data[$c1] ) != 'array'
            || !isset( $this->data[$c2] ) || gettype( $this->data[$c2] ) != 'array'
        ){
            throw new Exception(ERRORINPUTDATA);
        }

        $commands = [
            $c1 => $this->data[$c1],
            $c2 => $this->data[$c2],
        ];

        if (
            !isset( $commands[ $c1 ] ) || gettype( $commands[ $c1 ] ) != 'array'
            || !isset($commands[ $c1 ][ $goals = 'goals']) || gettype( $commands[ $c1] [ $goals ] ) != 'array'
            || !isset($commands[ $c1 ][ $games = 'games'])
            || !is_numeric ($commands[ $c1 ][ $goals ][ $scored = 'scored' ])
            || !is_numeric ($commands[ $c1 ][ $goals ][ $skiped = 'skiped' ])

            || !isset( $commands[ $c2 ] ) || gettype( $commands[ $c2 ] ) != 'array'
            || !isset( $commands[ $c2 ][ $goals ] ) || gettype( $commands[  $c2  ][ $goals ] ) != 'array'
            || !isset( $commands[ $c2 ][ $games ] )
            || !is_numeric( $commands[ $c2 ][ $goals ][ $scored ] )
            || !is_numeric( $commands[ $c2 ][ $goals ][ $skiped ] )
        ){
            throw new Exception(ERRORDATA);
        }

        #сила атаки
        $strenth_attack = [
            $c1 => round($commands[ $c1 ][ $goals ][ $scored  ] / $commands[ $c1 ][ $games ],ROUNDLIMIT),
            $c2 => round($commands[ $c2 ][ $goals ][ $scored ] / $commands[ $c2 ][ $games ],ROUNDLIMIT)
        ];

        #сила обороны
        $strenth_defend = [
            $c1 => round($commands[ $c1 ][ $goals ][ $skiped ] / $commands[ $c1 ][ $games ],ROUNDLIMIT),
            $c2 => round($commands[ $c2 ][ $goals ][ $skiped ] / $commands[ $c2 ][ $games ],ROUNDLIMIT)
        ];


        $probability =[
             rand(MINRAND,
                        round(
                            $strenth_attack[$c1]
                            *$strenth_defend[$c2]
                            *$strenth_attack[$c2]
                         )
            ),
            rand(MINRAND,
                        round(
                            $strenth_attack[$c2]
                            *$strenth_defend[$c1]
                            *$strenth_attack[$c1]
                        )
            )
        ];

        return $probability;
    }


}