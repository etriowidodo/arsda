<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p46".
 *
 * @property string $no_register_perkara
 * @property string $no_akta
 * @property string $no_reg_tahanan
 * @property string $kepada
 * @property string $di_kepada
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $alasan
 * @property string $pengadilan_tinggi
 * @property string $tgl_pengajuan
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
 * @property string $nip_ttd
 * @property string $biaya_perkara
 */
class PdmP46 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p46';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_akta', 'no_reg_tahanan'], 'required'],
            [['tgl_dikeluarkan', 'tgl_pengajuan', 'created_time', 'updated_time'], 'safe'],
            [['alasan'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['biaya_perkara'], 'number'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_reg_tahanan'], 'string', 'max' => 20],
            [['no_akta'], 'string', 'max' => 60],
            [['kepada', 'di_kepada', 'pengadilan_tinggi'], 'string', 'max' => 128],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['nama_ttd', 'pangkat_ttd', 'jabatan_ttd', 'nip_ttd'], 'string', 'max' => 100]
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
            'alasan' => 'Alasan',
            'pengadilan_tinggi' => 'Pengadilan Tinggi',
            'tgl_pengajuan' => 'Tgl Pengajuan',
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
            'nip_ttd' => 'Nip Ttd',
            'biaya_perkara' => 'Biaya Perkara',
        ];
    }
}
