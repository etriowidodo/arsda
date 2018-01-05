<?php

namespace app\modules\pengawasan\models;

use Yii;

class DipaMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_dipa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_dipa'], 'string'],
            [['dipa'], 'required'],
            [['dipa'], 'string', 'max'=> 60],
            //[['nama'], 'required'],
            [['tahun'], 'string', 'max' => 4],
            [['is_aktif'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_dipa' => 'Id Dipa',
            'dipa' => 'Dipa',
            'tahun' => 'Tahun',
            'is_aktif' => 'Is Aktif'
        ];
    }
}
