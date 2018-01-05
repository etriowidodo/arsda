<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p35".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_p35
 * @property string $sifat
 * @property string $lampiran
 * @property string $kepada
 * @property string $di_kepada
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_tersangka
 * @property string $dakwaan
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
 * @property string $no_reg_tahanan
 * @property string $dilimpahkan
 * @property string $tgl_limpah
 * @property string $nama_ttd
 * @property string $pangkat_ttd
 * @property string $jabatan_ttd
 */
class PdmP35 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p35';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p35', 'created_by', 'updated_by'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time', 'tgl_limpah'], 'safe'],
            [['dakwaan'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_p35'], 'string', 'max' => 50],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['lampiran', 'id_tersangka'], 'string', 'max' => 16],
            [['kepada', 'di_kepada'], 'string', 'max' => 128],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['no_reg_tahanan', 'dilimpahkan'], 'string', 'max' => 60],
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
            'no_surat_p35' => 'No Surat P35',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di Kepada',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_tersangka' => 'Id Tersangka',
            'dakwaan' => 'Dakwaan',
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
            'no_reg_tahanan' => 'No Reg Tahanan',
            'dilimpahkan' => 'Dilimpahkan',
            'tgl_limpah' => 'Tgl Limpah',
            'nama_ttd' => 'Nama Ttd',
            'pangkat_ttd' => 'Pangkat Ttd',
            'jabatan_ttd' => 'Jabatan Ttd',
        ];
    }
}
