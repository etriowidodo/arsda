<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ms_jkl".
 *
 * @property integer $id_jkl
 * @property string $nama
 *
 * @property PidumMsTersangka[] $pidumMsTersangkas
 */
class MsJkl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ms_jkl';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_jkl' => 'Id Jkl',
            'nama' => 'Nama',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPidumMsTersangkas()
    {
        return $this->hasMany(PidumMsTersangka::className(), ['id_jkl' => 'id_jkl']);
    }
}
