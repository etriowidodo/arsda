<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p11".
 *
 * @property string $id_p11
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $sifat
 * @property string $lampiran
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $kepada
 * @property string $di
 * @property string $id_penandatangan
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmP11 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p11';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p11', 'id_perkara', 'no_surat', 'lampiran', 'dikeluarkan', 'kepada'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_p11', 'id_perkara', 'lampiran'], 'string', 'max' => 16],
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
            'id_p11' => 'Id P11',
            'id_perkara' => 'Id Perkara',
            'no_surat' => 'No Surat',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'kepada' => 'Kepada',
            'di_kepada' => 'di_kepada',
            'id_penandatangan' => 'Id Penandatangan',
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
