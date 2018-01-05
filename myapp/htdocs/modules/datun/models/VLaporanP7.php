<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.v_laporan_p7".
 *
 * @property string $satker
 * @property string $tgl_terima
 * @property string $kejaksaan
 * @property string $tindak_pidana
 * @property string $pasal
 * @property string $sisa_bulan_lalu
 * @property string $masuk_bulan_lap
 * @property string $kirim_instansi_lain
 * @property string $dihentikan
 * @property string $kepentingan_umum
 * @property string $apb
 * @property string $aps
 * @property string $jml_selesai
 * @property string $proses_persidangan
 * @property string $putus_pn
 */
class VLaporanP7 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.v_laporan_p7';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_terima'], 'safe'],
            [['pasal', 'sisa_bulan_lalu', 'masuk_bulan_lap', 'kirim_instansi_lain', 'dihentikan', 'kepentingan_umum', 'apb', 'aps', 'jml_selesai', 'proses_persidangan', 'putus_pn'], 'string'],
            [['satker'], 'string', 'max' => 11],
            [['kejaksaan'], 'string', 'max' => 100],
            [['tindak_pidana'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'satker' => 'Satker',
            'tgl_terima' => 'Tgl Terima',
            'kejaksaan' => 'Kejaksaan',
            'tindak_pidana' => 'Tindak Pidana',
            'pasal' => 'Pasal',
            'sisa_bulan_lalu' => 'Sisa Bulan Lalu',
            'masuk_bulan_lap' => 'Masuk Bulan Lap',
            'kirim_instansi_lain' => 'Kirim Instansi Lain',
            'dihentikan' => 'Dihentikan',
            'kepentingan_umum' => 'Kepentingan Umum',
            'apb' => 'Apb',
            'aps' => 'Aps',
            'jml_selesai' => 'Jml Selesai',
            'proses_persidangan' => 'Proses Persidangan',
            'putus_pn' => 'Putus Pn',
        ];
    }
}
