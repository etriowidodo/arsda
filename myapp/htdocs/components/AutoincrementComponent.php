<?php
/**
 * Created by PhpStorm.
 * User: rio
 * Date: 24/06/15
 * Time: 13:37
 */

namespace app\components;


use Yii;
use yii\base\Component;

class AutoincrementComponent extends Component
{
    public function init(){
        parent::init();
    }

    public static function Generate($KeyLength){
        $connection = Yii::$app->db;
        //$query = $connection->createCommand("LOCK TABLE public.sys_fw_lock WRITE;");
        //$lock = $query->query();

        $str_micro_time = strval(microtime(false));
        $arr_time = explode(' ', $str_micro_time);
        $today = $arr_time[1] . $arr_time[0];
        usleep(1);
        //$query2 = $connection->createCommand("UNLOCK TABLES;");
        //$lock2 = $query2->query();
        $key = str_pad(str_replace( '.', '', $today), $KeyLength, "0", STR_PAD_LEFT);
        return $key;
    }
}