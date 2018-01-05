<?php

namespace app\modules\pengawasan\models;

use Yii;

class Irmud extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.irmud';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_irmud'], 'integer'],
            [['nama_irmud'], 'required'],
            [['nama_irmud'], 'string', 'max' => 50],
            [['akronim'], 'string', 'max' => 35],
            [['kode_surat'], 'string', 'max' => 6],
            [['id_inspektur'], 'integer'],
            [['id_inspektur'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nama_irmud' => 'Nama Irmud',
            'akronim' => 'Akronim',
        ];
    }
}
