<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p45_upayahukum".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_p45
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
 * @property string $menyatakan
 * @property string $tgl_tuntutan
 * @property string $menuntut
 * @property string $pernyataan_terdakwa
 * @property string $pernyataan_jaksa
 * @property string $pertimbangan
 * @property string $id_penandatangan
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmP45Upayahukum extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p45_upayahukum';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p45', 'created_by', 'updated_by'], 'required'],
            [['tgl_dikeluarkan', 'tgl_put_pengadilan', 'tgl_tuntutan', 'created_time', 'updated_time'], 'safe'],
            [['menyatakan', 'menuntut', 'pernyataan_terdakwa', 'pernyataan_jaksa', 'pertimbangan'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['lampiran', 'id_tersangka'], 'string', 'max' => 16],
            [['no_surat_p45'], 'string', 'max' => 50],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['kepada', 'di_kepada', 'put_pengadilan'], 'string', 'max' => 128],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['no_put_pengadilan'], 'string', 'max' => 32],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['no_akta'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_surat_p45' => 'No Surat P45',
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
            'menyatakan' => 'Menyatakan',
            'tgl_tuntutan' => 'Tgl Tuntutan',
            'menuntut' => 'Menuntut',
            'pernyataan_terdakwa' => 'Pernyataan Terdakwa',
            'pernyataan_jaksa' => 'Pernyataan Jaksa',
            'pertimbangan' => 'Pertimbangan',
            'id_penandatangan' => 'Id Penandatangan',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
