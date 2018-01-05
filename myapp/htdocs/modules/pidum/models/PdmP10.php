<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p10".
 *
 * @property string $id_p10
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $sifat
 * @property string $lampiran
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $kepada
 * @property string $di_kepada
 * @property string $ket_ahli
 * @property string $id_penandatangan
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmP10 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p10';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p10', 'no_surat', 'sifat', 'tgl_dikeluarkan','id_penandatangan'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['ket_ahli'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_p10', 'id_perkara', 'lampiran'], 'string', 'max' => 16],
            [['no_surat', 'di_kepada'], 'string', 'max' => 32],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['dikeluarkan', 'kepada'], 'string', 'max' => 64],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_p10' => 'Id P10',
            'id_perkara' => 'Id Perkara',
            'no_surat' => 'No Surat',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di Kepada',
            'ket_ahli' => 'Ket Ahli',
            'id_penandatangan' => 'Penandatangan',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
