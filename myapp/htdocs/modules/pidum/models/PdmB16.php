<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_b16".
 *
 * @property string $id_b16
 * @property string $id_perkara
 * @property string $no_surat
 * @property string $sifat
 * @property string $lampiran
 * @property string $kepada
 * @property string $di_kepada
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_tersangka
 * @property string $pelaksanaan_lelang
 * @property string $tgl_lelang
 * @property string $total
 * @property string $bank
 * @property string $ba_penitipan
 * @property string $tgl_ba
 * @property string $no_persetujuan
 * @property string $tgl_persetujuan
 * @property string $kantor_lelang
 * @property string $no_risalan
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
class PdmB16 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_b16';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_b16'], 'required'],
            [['tgl_dikeluarkan', 'tgl_lelang', 'tgl_ba', 'tgl_persetujuan', 'created_time', 'updated_time'], 'safe'],
            [['total'], 'number'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_b16', 'id_perkara', 'lampiran', 'id_tersangka'], 'string', 'max' => 16],
            [['no_surat', 'ba_penitipan', 'no_risalan'], 'string', 'max' => 32],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['kepada', 'di_kepada', 'pelaksanaan_lelang', 'surat_perintah_kepada', 'lokasi_penetapan'], 'string', 'max' => 128],
            [['dikeluarkan', 'bank', 'no_persetujuan', 'kantor_lelang'], 'string', 'max' => 64],
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
            'id_b16' => 'Id B16',
            'id_perkara' => 'Id Perkara',
            'no_surat' => 'No Surat',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di Kepada',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_tersangka' => 'Id Tersangka',
            'pelaksanaan_lelang' => 'Pelaksanaan Lelang',
            'tgl_lelang' => 'Tgl Lelang',
            'total' => 'Total',
            'bank' => 'Bank',
            'ba_penitipan' => 'Ba Penitipan',
            'tgl_ba' => 'Tgl Ba',
            'no_persetujuan' => 'No Persetujuan',
            'tgl_persetujuan' => 'Tgl Persetujuan',
            'kantor_lelang' => 'Kantor Lelang',
            'no_risalan' => 'No Risalan',
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
    public function getIdPerkara()
    {
        return $this->hasOne(PdmSpdp::className(), ['id_perkara' => 'id_perkara']);
    }
}
