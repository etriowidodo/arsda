<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_pendidikan".
 *
 * @property integer $id_pendidikan
 * @property string $nama
 *
 * @property PidumMsTersangka[] $pidumMsTersangkas
 */
class MsPendidikan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_pendidikan';
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
            'id_pendidikan' => 'Id Pendidikan',
            'nama' => 'Nama',
            'umur' => 'Umur'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPidumMsTersangkas()
    {
        return $this->hasMany(PidumMsTersangka::className(), ['id_pendidikan' => 'id_pendidikan']);
    }
}
