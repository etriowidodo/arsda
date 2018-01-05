<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ms_satuan".
 *
 * @property integer $id
 * @property string $nama
 *
 * @property PdmBarbukTambahan[] $pdmBarbukTambahans
 */
class PdmMsSatuan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ms_satuan';
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
    public function getPdmBarbukTambahans()
    {
        return $this->hasMany(PdmBarbukTambahan::className(), ['id_satuan' => 'id']);
    }
}
