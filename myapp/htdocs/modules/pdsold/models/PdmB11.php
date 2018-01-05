<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_b11".
 *
 * @property string $id_b11
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $sifat
 * @property string $lampiran
 * @property string $kepada
 * @property string $di_kepada
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property integer $id_msjnsbrng
 * @property string $lokasi
 * @property string $id_penandatangan
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 *
 * @property PdmMsJnsbrng $idMsjnsbrng
 */
class PdmB11 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_b11';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_b11'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['id_msjnsbrng', 'created_by', 'updated_by'], 'integer'],
            [['id_b11', 'id_perkara', 'lampiran'], 'string', 'max' => 16],
            [['no_surat'], 'string', 'max' => 32],
            [['isi_barbuk'], 'string', 'max' => 250],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['kepada', 'di_kepada', 'lokasi'], 'string', 'max' => 128],
            [['dikeluarkan'], 'string', 'max' => 64],
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
            'id_b11' => 'Id B11',
            'id_perkara' => 'Id Perkara',
            'no_surat' => 'No Surat',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di Kepada',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_msjnsbrng' => 'Id Msjnsbrng',
            'lokasi' => 'Lokasi',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdMsjnsbrng()
    {
        return $this->hasOne(PdmMsJnsbrng::className(), ['id' => 'id_msjnsbrng']);
    }
}