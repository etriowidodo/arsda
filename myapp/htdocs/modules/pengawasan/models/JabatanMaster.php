<?php

namespace app\modules\pengawasan\models;

use Yii;

class JabatanMaster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_jabatan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_jabatan'], 'string'],
            //[['id_jabatan'], 'required'],
            //[['nama'], 'required'],
            [['nama'], 'string', 'max' => 65],
            [['akronim'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_jabatan' => 'Id Jabatan',
            'nama' => 'Nama',
            'akronim' => 'Akronim',
        ];
    }
}
