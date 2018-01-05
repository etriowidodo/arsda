<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_identitas".
 *
 * @property integer $id_identitas
 * @property string $nama
 *
 * @property PidumMsTersangka[] $pidumMsTersangkas
 */
class MsIdentitas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_identitas';
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
            'id_identitas' => 'Id Identitas',
            'nama' => 'Nama',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPidumMsTersangkas()
    {
        return $this->hasMany(PidumMsTersangka::className(), ['id_identitas' => 'id_identitas']);
    }
}
