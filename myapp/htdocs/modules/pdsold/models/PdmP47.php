<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p47".
 *
 * @property string $no_register_perkara
 * @property string $no_akta
 * @property string $no_reg_tahanan
 * @property string $kepada
 * @property string $di_kepada
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $dakwaan
 * @property string $pengadilan_negeri
 * @property string $lokasi
 * @property string $alasan
 * @property string $penetapan_hakim
 * @property string $hukpid
 * @property string $denda
 * @property string $biaya_perkara
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $nip_ttd
 * @property string $nama_ttd
 * @property string $jabatan_ttd
 * @property string $pangkat_ttd
 * @property string $pertimbangan
 * @property integer $pengadilan
 */
class PdmP47 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p47';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_akta', 'no_reg_tahanan'], 'required'],
            [['tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['dakwaan', 'alasan', 'penetapan_hakim', 'pertimbangan'], 'string'],
            [['denda', 'biaya_perkara'], 'number'],
            [['created_by', 'updated_by', 'pengadilan'], 'integer'],
            [['no_register_perkara', 'no_reg_tahanan'], 'string', 'max' => 30],
            [['no_akta'], 'string', 'max' => 60],
            [['kepada', 'di_kepada', 'pengadilan_negeri', 'lokasi', 'hukpid'], 'string', 'max' => 128],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['nip_ttd'], 'string', 'max' => 20],
            [['nama_ttd'], 'string', 'max' => 100],
            [['jabatan_ttd', 'pangkat_ttd'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_akta' => 'No Akta',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'kepada' => 'Kepada',
            'di_kepada' => 'Di Kepada',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'dakwaan' => 'Dakwaan',
            'pengadilan_negeri' => 'Pengadilan Negeri',
            'lokasi' => 'Lokasi',
            'alasan' => 'Alasan',
            'penetapan_hakim' => 'Penetapan Hakim',
            'hukpid' => 'Hukpid',
            'denda' => 'Denda',
            'biaya_perkara' => 'Biaya Perkara',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'nip_ttd' => 'Nip Ttd',
            'nama_ttd' => 'Nama Ttd',
            'jabatan_ttd' => 'Jabatan Ttd',
            'pangkat_ttd' => 'Pangkat Ttd',
            'pertimbangan' => 'Pertimbangan',
            'pengadilan' => 'Pengadilan',
        ];
    }
}
