<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_agama".
 *
 * @property integer $id_agama
 * @property string $nama
 *
 * @property PidumMsTersangka[] $pidumMsTersangkas
 */
class MsAgama extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_agama';
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
            'id_agama' => 'Id Agama',
            'nama' => 'Nama',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPidumMsTersangkas()
    {
        return $this->hasMany(PidumMsTersangka::className(), ['id_agama' => 'id_agama']);
    }
}
