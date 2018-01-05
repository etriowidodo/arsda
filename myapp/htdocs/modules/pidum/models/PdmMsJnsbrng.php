<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ms_jnsbrng".
 *
 * @property integer $id
 * @property string $nama
 *
 * @property PdmB11[] $pdmB11s
 */
class PdmMsJnsbrng extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ms_jnsbrng';
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmB11s()
    {
        return $this->hasMany(PdmB11::className(), ['id_msjnsbrng' => 'id']);
    }
}
