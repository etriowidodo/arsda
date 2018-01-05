<?php

namespace app\modules\datun\models;

use Yii;

/**
 * This is the model class for table "datun.m_propinsi".
 *
 * @property string $id_prop
 * @property string $deskripsi
 */
 
class MsWilayah extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'datun.m_propinsi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_prop'], 'required'],
            [['id_prop'], 'string', 'max' => 2],
            [['deskripsi'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_prop' => 'Kode',
            'deskripsi' => 'Deskripsi',
        ];
    }

    /**
     * @inheritdoc
     * @return MsInstPenyidikQuery the active query used by this AR class.
     */
 
}
