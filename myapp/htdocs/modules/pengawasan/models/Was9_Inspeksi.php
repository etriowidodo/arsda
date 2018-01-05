<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was9".
 *
 * @property string $id_was9
 * @property string $tanggal_was9
 * @property string $perihal_was9
 * @property string $lampiran_was9
 * @property string $id_saksi_was9
 * @property string $no_register
 * @property string $jenis_saksi
 * @property string $nip
 * @property string $hari_pemeriksaan_was9
 * @property string $tanggal_pemeriksaan_was9
 * @property string $jam_pemeriksaan_was9
 * @property string $tempat_pemeriksaan_was9
 * @property string $nip_penandatangan
 * @property string $nama_penandatangan
 * @property string $pangkat_penandatangan
 * @property string $golongan_penandatangan
 * @property string $jabatan_penandatangan
 * @property string $was9_file
 * @property string $id_sp_was
 * @property string $sifat_was9
 */
class was9_inspeksi extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was9_inspeksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        
            // [['id_was9'], 'required'],
            [['tanggal_was9', 'tanggal_pemeriksaan_was9', 'jam_pemeriksaan_was9','created_time','updated_time'], 'safe'],
           // [['id_was9','id_sp_was'], 'string', 'max' => 16],

            [['sifat_was9','id_pemeriksa','id_sp_was2','id_surat_was9','id_saksi_internal','id_saksi_eksternal'], 'integer'],
            [['trx_akhir','created_by','updated_by'], 'integer'],
            [['updated_ip','created_ip'], 'string', 'max' => 15],
            [['nomor_sp_was'], 'string', 'max' => 50],
            [['perihal_was9', 'tempat_pemeriksaan_was9'], 'string', 'max' => 1000],
            [['lampiran_was9','golongan_pemeriksa'], 'string', 'max' => 20],
            [['nrp_pemeriksa'], 'string', 'max' => 10],
            [['nomor_surat_was9','jabatan_pemeriksa'], 'string', 'max' => 65],
            [['nip_penandatangan','nip_pemeriksa'], 'string', 'max' => 18],
            [['jenis_saksi'], 'string', 'max' => 9],
            [['hari_pemeriksaan_was9'], 'string', 'max' => 6],
            [['nama_penandatangan','nama_pemeriksa','di_was9'], 'string', 'max' => 100],
            [['pangkat_penandatangan', 'was9_file','pangkat_pemeriksa'], 'string', 'max' => 30],
            [['golongan_penandatangan'], 'string', 'max' => 5],
            [['jabatan_penandatangan','jbtn_penandatangan'], 'string', 'max' => 65],
            [['id_tingkat','id_kejari','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
            [['no_register'], 'string', 'max' => 25],
            [['zona_waktu'], 'string', 'max' => 5],
         //   [['inst_satkerkd'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
          //  'id_was9' => 'Id Was9',
            'nomor_surat_was9' => 'No Surat was9',
            'tanggal_was9' => 'Tanggal Was9',
            'perihal_was9' => 'Perihal Was9',
            'lampiran_was9' => 'Lampiran Was9',
            'no_register' => 'Id Register',
            'jenis_saksi' => 'Jenis Saksi',
            'status_penandatangan' => 'id jabatan',
            'hari_pemeriksaan_was9' => 'Hari Pemeriksaan Was9',
            'tanggal_pemeriksaan_was9' => 'Tanggal Pemeriksaan Was9',
            'jam_pemeriksaan_was9' => 'Jam Pemeriksaan Was9',
            'tempat_pemeriksaan_was9' => 'Tempat Pemeriksaan Was9',
            'nip_penandatangan' => 'Nip Penandatangan',
            'nama_penandatangan' => 'Nama Penandatangan Was9',
            'pangkat_penandatangan' => 'Pangkat Penandatangan',
            'golongan_penandatangan' => 'Golongan Penandatangan',
            'jabatan_penandatangan' => 'Jabatan Penandatangan',
            'was9_file' => 'Was9 File',
          //  'id_sp_was' => 'Id Sp Was',
            'sifat_was9' => 'Sifat Was9',
            'no_register' => 'no_register',
        ];
    }
}
