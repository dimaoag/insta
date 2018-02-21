<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 19.02.18
 * Time: 21:35
 */

namespace frontend\components;


class Debug
{

    public static function debugging($array){

        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }

}