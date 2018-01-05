<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ms_jns_pengadilan".
 *
 * @property integer $id
 * @property string $nama
 *
 * @property PdmP31[] $pdmP31s
 */
class PdmMsJnsPengadilan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ms_jns_pengadilan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama'], 'string', 'max' => 200]
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
    public function getPdmP31s()
    {
        return $this->hasMany(PdmP31::className(), ['id_ms_jnspengadilan' => 'id']);
    }
}
