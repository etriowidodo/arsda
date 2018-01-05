<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "simkari.pds_lid_surat_dummy".
 *
 * @property string $id_lid_surat
 * @property string $type_surat
 * @property string $kejaksaan
 * @property string $nomor
 * @property string $sifat
 * @property string $perihal
 * @property string $tempat_surat
 * @property string $kepada
 * @property string $tempat_tujuan
 * @property string $tanggal_surat
 * @property string $nomor_pengaduan
 * @property string $tanggal_pengaduan
 * @property integer $jabatan_penandatangan
 * @property string $nama_penandatangan
 * @property string $pangkatnip
 * @property string $tindak_lanjut
 */
class PdsLidSuratDummy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'simkari.pds_lid_surat_dummy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_lid_surat'], 'required'],
            [['tanggal_surat', 'tanggal_pengaduan'], 'safe'],
            [['jabatan_penandatangan'], 'integer'],
            [['id_lid_surat', 'sifat', 'perihal', 'tempat_surat', 'tempat_tujuan'], 'string', 'max' => 20],
            [['type_surat', 'nomor', 'nomor_pengaduan'], 'string', 'max' => 10],
            [['kejaksaan'], 'string', 'max' => 50],
            [['kepada', 'nama_penandatangan', 'pangkatnip'], 'string', 'max' => 30],
            [['tindak_lanjut'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_lid_surat' => 'Id Lid Surat',
            'type_surat' => 'Type Surat',
            'kejaksaan' => 'Kejaksaan',
            'nomor' => 'Nomor',
            'sifat' => 'Sifat',
            'perihal' => 'Perihal',
            'tempat_surat' => 'Tempat Surat',
            'kepada' => 'Kepada',
            'tempat_tujuan' => 'Tempat Tujuan',
            'tanggal_surat' => 'Tanggal Surat',
            'nomor_pengaduan' => 'Nomor Pengaduan',
            'tanggal_pengaduan' => 'Tanggal Pengaduan',
            'jabatan_penandatangan' => 'Jabatan Penandatangan',
            'nama_penandatangan' => 'Nama Penandatangan',
            'pangkatnip' => 'Pangkatnip',
            'tindak_lanjut' => 'Tindak Lanjut',
        ];
    }
}
