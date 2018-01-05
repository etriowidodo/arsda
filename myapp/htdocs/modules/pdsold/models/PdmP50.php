<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p50".
 *
 * @property string $no_surat_p50
 * @property string $no_register_perkara
 * @property string $no_surat
 * @property string $sifat
 * @property string $lampiran
 * @property string $kepada
 * @property string $di_kepada
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_tersangka
 * @property string $put_pengadilan
 * @property string $no_put_pengadilan
 * @property string $tgl_put_pengadilan
 * @property string $tgl_pelaksanaan
 * @property string $uraian
 * @property string $id_penandatangan
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $no_akta
 * @property string $no_reg_tahanan
 */
class PdmP50 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p50';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_surat_p50', 'no_register_perkara', 'no_akta', 'no_reg_tahanan'], 'required'],
            [['tgl_dikeluarkan', 'tgl_put_pengadilan', 'tgl_pelaksanaan', 'created_time', 'updated_time'], 'safe'],
            [['uraian'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_surat_p50', 'lampiran', 'id_tersangka'], 'string', 'max' => 16],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat'], 'string', 'max' => 50],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['kepada', 'di_kepada', 'put_pengadilan'], 'string', 'max' => 128],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['no_put_pengadilan'], 'string', 'max' => 32],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['no_akta', 'no_reg_tahanan'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_surat_p50' => 'No Surat P50',
            'no_register_perkara' => 'No Register Perkara',
            'no_surat' => 'No Surat',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di Kepada',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_tersangka' => 'Id Tersangka',
            'put_pengadilan' => 'Put Pengadilan',
            'no_put_pengadilan' => 'No Put Pengadilan',
            'tgl_put_pengadilan' => 'Tgl Put Pengadilan',
            'tgl_pelaksanaan' => 'Tgl Pelaksanaan',
            'uraian' => 'Uraian',
            'id_penandatangan' => 'Id Penandatangan',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'no_akta' => 'No Akta',
            'no_reg_tahanan' => 'No Reg Tahanan',
        ];
    }
}
