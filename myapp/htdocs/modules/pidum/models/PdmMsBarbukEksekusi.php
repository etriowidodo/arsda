<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ms_barbuk_eksekusi".
 *
 * @property integer $id
 * @property string $nama
 * @property string $flag
 *
 * @property PdmBarbuk[] $pdmBarbuks
 * @property PdmBarbukTambahan[] $pdmBarbukTambahans
 */
class PdmMsBarbukEksekusi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ms_barbuk_eksekusi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama'], 'string', 'max' => 50],
            [['flag'], 'string', 'max' => 1]
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
            'flag' => 'Flag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmBarbuks()
    {
        return $this->hasMany(PdmBarbuk::className(), ['id_ms_barbuk_eksekusi' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmBarbukTambahans()
    {
        return $this->hasMany(PdmBarbukTambahan::className(), ['id_ms_barbuk_eksekusi' => 'id']);
    }
}
