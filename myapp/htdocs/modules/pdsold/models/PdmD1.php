<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_d1".
 *
 * @property string $no_eksekusi
 * @property string $no_surat
 * @property string $sifat
 * @property string $lampiran
 * @property string $kepada
 * @property string $di_kepada
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $tgl_panggil
 * @property string $jam_panggil
 * @property string $menghadap
 * @property string $tgl_relas
 * @property string $jam_relas
 * @property integer $id_msstatusdata
 * @property string $id_penandatangan
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $nama_ttd
 * @property string $pangkat_ttd
 * @property string $jabatan_ttd
 * @property string $no_reg_tahanan
 * @property string $nama_relas
 * @property string $pangkat_relas
 * @property string $no_register_perkara
 */
class PdmD1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_d1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_eksekusi', 'no_surat'], 'required'],
            [['tgl_dikeluarkan', 'tgl_panggil', 'jam_panggil', 'tgl_relas', 'jam_relas', 'created_time', 'updated_time'], 'safe'],
            [['id_msstatusdata', 'created_by', 'updated_by'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_eksekusi', 'lampiran'], 'string', 'max' => 16],
            [['no_surat'], 'string', 'max' => 50],
            [['sifat', 'id_penandatangan'], 'string', 'max' => 20],
            [['kepada', 'di_kepada'], 'string', 'max' => 128],
            [['dikeluarkan', 'menghadap'], 'string', 'max' => 64],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['nama_ttd', 'pangkat_ttd', 'jabatan_ttd', 'nama_relas', 'pangkat_relas'], 'string', 'max' => 100],
            [['no_reg_tahanan'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_eksekusi' => 'No Eksekusi',
            'no_surat' => 'No Surat',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di Kepada',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'tgl_panggil' => 'Tgl Panggil',
            'jam_panggil' => 'Jam Panggil',
            'menghadap' => 'Menghadap',
            'tgl_relas' => 'Tgl Relas',
            'jam_relas' => 'Jam Relas',
            'id_msstatusdata' => 'Id Msstatusdata',
            'id_penandatangan' => 'Id Penandatangan',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'nama_ttd' => 'Nama Ttd',
            'pangkat_ttd' => 'Pangkat Ttd',
            'jabatan_ttd' => 'Jabatan Ttd',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'nama_relas' => 'Nama Relas',
            'pangkat_relas' => 'Pangkat Relas',
            'no_register_perkara' => 'No Register Perkara',
        ];
    }
}
