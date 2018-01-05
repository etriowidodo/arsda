<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p31".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_p31
 * @property string $id_tersangka
 * @property integer $id_ms_jnspengadilan
 * @property string $lokasi_pengadilan
 * @property integer $id_ms_loktahanan
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
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
 * @property string $nama_ttd
 * @property string $pangkat_ttd
 * @property string $jabatan_ttd
 */
class PdmP31 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p31';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p31', 'created_by', 'updated_by'], 'required'],
            [['id_ms_jnspengadilan', 'id_ms_loktahanan', 'created_by', 'updated_by'], 'integer'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_p31'], 'string', 'max' => 50],
            [['id_tersangka'], 'string', 'max' => 16],
            [['lokasi_pengadilan'], 'string', 'max' => 128],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['id_penandatangan'], 'string', 'max' => 20],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['nama_ttd', 'pangkat_ttd', 'jabatan_ttd'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_surat_p31' => 'No Surat P31',
            'id_tersangka' => 'Id Tersangka',
            'id_ms_jnspengadilan' => 'Id Ms Jnspengadilan',
            'lokasi_pengadilan' => 'Lokasi Pengadilan',
            'id_ms_loktahanan' => 'Id Ms Loktahanan',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
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
            'nama_ttd' => 'Nama Ttd',
            'pangkat_ttd' => 'Pangkat Ttd',
            'jabatan_ttd' => 'Jabatan Ttd',
        ];
    }
}
