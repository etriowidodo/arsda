<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;

class TahapBantuanHukum extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'datun.tr_tahap_bankum';
    }
}
