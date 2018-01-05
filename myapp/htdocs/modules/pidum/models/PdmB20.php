<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_b20".
 *
 * @property string $id_b20
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $sifat
 * @property string $lampiran
 * @property string $kepada
 * @property string $di_kepada
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $barbuk
 * @property string $alasan
 * @property string $dimanfaatkan
 * @property string $id_penandatangan
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 *
 * @property PdmSpdp $idPerkara
 */
class PdmB20 extends \app\models\BaseModel {

    /**
     * @inheritdoc
     */
    public $id_msstatusdata;

    public static function tableName() {
        return 'pidum.pdm_b20';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id_b20'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['barbuk', 'alasan', 'dimanfaatkan'], 'string'],
            [['created_by', 'updated_by', 'id_statusbrng', 'id_manfaatbrng'], 'integer'],
            [['id_b20', 'id_perkara', 'lampiran'], 'string', 'max' => 16],
            [['no_surat'], 'string', 'max' => 32],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['kepada', 'di_kepada'], 'string', 'max' => 128],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id_b20' => 'Id B20',
            'id_perkara' => 'Id Perkara',
            'no_surat' => 'No Surat',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di Kepada',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'barbuk' => 'Barbuk',
            'alasan' => 'Alasan',
            'dimanfaatkan' => 'Dimanfaatkan',
            'id_penandatangan' => 'Id Penandatangan',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'id_statusbrng' => 'Status Barang',
            'id_manfaatbrng' => 'id_manfaatbrng'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPerkara() {
        return $this->hasOne(PdmSpdp::className(), ['id_perkara' => 'id_perkara']);
    }

}
