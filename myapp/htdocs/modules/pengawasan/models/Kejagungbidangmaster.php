<?php

namespace app\modules\pengawasan\models;

use Yii;

class Kejagungbidangmaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.kejagung_bidang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_kejagung_bidang'], 'integer'],
            [['nama_kejagung_bidang'], 'required'],
            [['nama_kejagung_bidang'], 'string', 'max' => 65],
            [['id_inspektur'], 'integer'],
            [['akronim'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'id_kejagung_bidang' => 'Id Kejagung_bidang',
            'nama_kejagung_bidang' => 'Nama Kejagung Bidang',
            'id_inspektur' => 'Id Inspektur',
            'akronim' => 'Akronim',
        ];
    }
}
