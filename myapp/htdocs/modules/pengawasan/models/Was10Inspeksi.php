<?php

namespace app\modules\pengawasan\models;

use Yii;

class was10Inspeksi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was10_inspeksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['was10_tanggal', 'created_time', 'updated_time', 'tanggal_pemeriksaan_was10', 'jam_pemeriksaan_was10'], 'safe'],
            [['was10_perihal', 'tempat_pemeriksaan_was10'], 'string'],
            [['created_by', 'updated_by', 'zona_waktu', 'sifat_surat','id_pemeriksa','id_pegawai_terlapor','trx_akhir'], 'integer'],
            [[ 'no_register'], 'string', 'max' => 25],
            [['jabatan_penandatangan', 'satker_pegawai_terlapor', 'jabatan_pemeriksa','jbtn_penandatangan'], 'string', 'max' => 65],
            [['was10_lampiran', 'created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['pangkat_penandatangan', 'pangkat_pegawai_terlapor', 'pangkat_pemeriksa','nip_pegawai_terlapor'], 'string', 'max' => 30],
            [['golongan_penandatangan', 'golongan_pegawai_terlapor','was10_file', 'no_surat'], 'string', 'max' => 50],
            [['nip_penandatangan', 'nip_pemeriksa'], 'string', 'max' => 18],
            [['nrp_pemeriksa'], 'string', 'max' => 10],
            [['hari_pemeriksaan_was10'], 'string', 'max' => 6],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
            [['jabatan_pegawai_terlapor','nama_penandatangan','nama_pemeriksa','nama_pegawai_terlapor','di_was10'], 'string', 'max' => 100],
            [['golongan_pemeriksa'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           // 'id_was10' => 'Id Was10',
            'was10_tanggal' => 'Was10 Tanggal',
            'was10_lampiran' => 'Was10 Lampiran',
            'was10_perihal' => 'Was10 Perihal',
            'was10_file' => 'Was10 File',
            'nama_penandatangan' => 'Nama Penandatangan',
            'pangkat_penandatangan' => 'Pangkat Penandatangan',
            'golongan_penandatangan' => 'Golongan Penandatangan',
            'jabatan_penandatangan' => 'Jabatan Penandatangan',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_by' => 'Updated By',
            'updated_ip' => 'Updated Ip',
            'updated_time' => 'Updated Time',
            'no_register' => 'No Register',
            'nip_penandatangan' => 'Nip Penandatangan',
            'no_surat' => 'No Surat',
            'hari_pemeriksaan_was10' => 'Hari Pemeriksaan Was10',
            'tanggal_pemeriksaan_was10' => 'Tanggal Pemeriksaan Was10',
            'jam_pemeriksaan_was10' => 'Jam Pemeriksaan Was10',
            'tempat_pemeriksaan_was10' => 'Tempat Pemeriksaan Was10',
            'zona_waktu' => 'Zona Waktu',
            'sifat_surat' => 'Sifat Surat',
            'nip_pegawai_terlapor' => 'Nip Pegawai Terlapor',
            'nama_pegawai_terlapor' => 'Nama Pegawai Terlapor',
            'pangkat_pegawai_terlapor' => 'Pangkat Pegawai Terlapor',
            'golongan_pegawai_terlapor' => 'Golongan Pegawai Terlapor',
            'jabatan_pegawai_terlapor' => 'Jabatan Pegawai Terlapor',
            'satker_pegawai_terlapor' => 'Satker Pegawai Terlapor',
            'nip_pemeriksa' => 'Nip Pemeriksa',
            'nama_pemeriksa' => 'Nama Pemeriksa',
            'pangkat_pemeriksa' => 'Pangkat Pemeriksa',
            'jabatan_pemeriksa' => 'Jabatan Pemeriksa',
            'golongan_pemeriksa' => 'Golongan Pemeriksa',
        ];
    }
}
