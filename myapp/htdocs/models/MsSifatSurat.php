<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "public.ms_sifat_surat".
 *
 * @property integer $id
 * @property string $nama
 */
class MsSifatSurat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.ms_sifat_surat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
        ];
    }
}
