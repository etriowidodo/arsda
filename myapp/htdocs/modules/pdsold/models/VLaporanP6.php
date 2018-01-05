<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.v_laporan_p6".
 *
 * @property string $tgl_terima
 * @property string $wilayah_kerja
 * @property string $nama_lengkap
 * @property string $kasus_posisi
 * @property string $asal_perkara
 * @property string $tgl_dihentikan
 * @property string $tgl_dikesampingkan
 * @property string $tgl_dikirim_ke
 * @property string $no_denda_ganti
 * @property string $tgl_denda_ganti
 * @property string $tgl_dilimpahkan
 * @property string $keterangan
 */
class VLaporanP6 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.v_laporan_p6';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['wilayah_kerja'], 'required'],
            [['tgl_terima'], 'safe'],
            [['kasus_posisi', 'tgl_dihentikan', 'tgl_dikesampingkan', 'tgl_dikirim_ke', 'no_denda_ganti', 'tgl_denda_ganti', 'tgl_dilimpahkan', 'keterangan'], 'string'],
            [['wilayah_kerja'], 'string', 'max' => 11],
            [['nama_lengkap'], 'string', 'max' => 255],
            [['asal_perkara'], 'string', 'max' => 20]
        ];
    }

    public static function primaryKey()
    {
        return 'wilayah_kerja';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tgl_terima' => 'Tgl Terima',
            'wilayah_kerja' => 'Wilayah Kerja',
            'nama_lengkap' => 'Nama Lengkap',
            'kasus_posisi' => 'Kasus Posisi',
            'asal_perkara' => 'Asal Perkara',
            'tgl_dihentikan' => 'Tgl Dihentikan',
            'tgl_dikesampingkan' => 'Tgl Dikesampingkan',
            'tgl_dikirim_ke' => 'Tgl Dikirim Ke',
            'no_denda_ganti' => 'No Denda Ganti',
            'tgl_denda_ganti' => 'Tgl Denda Ganti',
            'tgl_dilimpahkan' => 'Tgl Dilimpahkan',
            'keterangan' => 'Keterangan',
        ];
    }
}
