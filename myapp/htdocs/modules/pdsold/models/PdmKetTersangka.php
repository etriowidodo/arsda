<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ket_tersangka".
 *
 * @property string $id_ket_tersangka
 * @property string $id_ba5
 * @property string $id_tersangka
 * @property string $keterangan
 * @property string $id_perkara
 * @property string $flag
 */
class PdmKetTersangka extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ket_tersangka';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ket_tersangka', 'id_perkara'], 'required'],
            [['keterangan'], 'string'],
            [['id_ket_tersangka', 'id_perkara'], 'string', 'max' => 16],
            [['id_ba5', 'id_tersangka'], 'string', 'max' => 32],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ket_tersangka' => 'Id Ket Tersangka',
            'id_ba5' => 'Id Ba5',
            'id_tersangka' => 'Id Tersangka',
            'keterangan' => 'Keterangan',
            'id_perkara' => 'Id Perkara',
            'flag' => 'Flag',
        ];
    }
}
