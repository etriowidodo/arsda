<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ms_hasil_berkas".
 *
 * @property integer $id
 * @property string $nama
 *
 * @property PdmP24[] $pdmP24s
 */
class PdmMsHasilBerkas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ms_hasil_berkas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama'], 'string', 'max' => 64]
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
    public function getPdmP24s()
    {
        return $this->hasMany(PdmP24::className(), ['id_ms_hasil_berkas' => 'id']);
    }
}
