<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_dasar_keputusan".
 *
 * @property string $id
 * @property string $kode_table
 * @property string $id_table
 * @property string $type_surat
 * @property string $isi_surat
 * @property string $flag
 */
class PdmDasarKeputusan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_dasar_keputusan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['isi_surat'], 'string'],
            [['id'], 'string', 'max' => 20],
            [['kode_table'], 'string', 'max' => 12],
            [['id_table'], 'string', 'max' => 20],
            [['type_surat'], 'string', 'max' => 32],
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
            'kode_table' => 'Kode Table',
            'id_table' => 'Id Table',
            'type_surat' => 'Type Surat',
            'isi_surat' => 'Isi Surat',
            'flag' => 'Flag',
        ];
    }
}
