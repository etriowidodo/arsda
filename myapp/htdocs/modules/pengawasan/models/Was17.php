<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_17".
 *
 * @property string $id_was_17
 * @property string $no_was_17
 * @property string $id_register
 * @property string $inst_satkerkd
 * @property string $tgl_was_17
 * @property integer $sifat_surat
 * @property integer $jml_lampiran
 * @property integer $satuan_lampiran
 * @property integer $kpd_was_17
 * @property string $id_terlapor
 * @property integer $id_peraturan
 * @property string $tingkat_kd
 * @property integer $jam
 * @property integer $ttd_was_17
 * @property string $ttd_peg_nik
 * @property integer $ttd_id_jabatan
 * @property string $upload_file
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $perihal
 **/
  
class Was17 extends \yii\db\ActiveRecord
{
    // public $no_register;
    // public $inst_nama;
    // public $ttd_peg_nama;
    // public $ttd_peg_nip;
    // public $ttd_peg_pangkat;
    // public $ttd_peg_jabatan;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_17';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_was_17', 'created_time', 'updated_time'], 'safe'],        
            [['id_sp_was2','id_ba_was2','id_l_was2','id_was15','id_was_17','id_wilayah','id_level1','id_level2','id_level3','id_level4','sifat_surat','created_by','updated_by'], 'integer'],
            [['id_tingkat'], 'string', 'max' => 1],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['no_register'], 'string', 'max' => 25],
            [['dari_was_17','kpd_was_17'], 'string', 'max' => 70],
            [['id_terlapor'], 'string', 'max' => 16],
            [['created_ip','updated_ip'], 'string', 'max' => 17],
            [['upload_file'], 'string', 'max' => 200],
            [['satker_pegawai_terlapor','jabatan_penandatangan','jbtn_penandatangan','jabatan_mkj','jbtn_mkj'], 'string', 'max' => 65],
            [['golongan_mkj'], 'string', 'max' => 5],
            [['pangkat_pegawai_terlapor','pangkat_penandatangan','nip_penandatangan','lampiran','pangkat_mkj'], 'string', 'max' => 30],
            [['golongan_pegawai_terlapor','no_was_17','golongan_penandatangan'], 'string', 'max' => 50],
            [['perihal','nama_pegawai_terlapor','jabatan_pegawai_terlapor','nama_penandatangan','nama_mkj','sk'], 'string', 'max' => 100],
            [['nrp_pegawai_terlapor'], 'string', 'max' => 10],
            [['nip_pegawai_terlapor','nip_mkj'], 'string', 'max' => 18],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_17' => 'Id Was 17',
            'no_was_17' => 'No Was 17',
            'id_register' => 'Id Register',
            'inst_satkerkd' => 'Inst Satkerkd',
            'tgl_was_17' => 'Tgl Was 17',
            'sifat_surat' => 'Sifat Surat',
            'jml_lampiran' => 'Jml Lampiran',
            'satuan_lampiran' => 'Satuan Lampiran',
            'kpd_was_17' => 'Kpd Was 17',
            'id_terlapor' => 'Id Terlapor',
            'id_peraturan' => 'Id Peraturan',
            'tingkat_kd' => 'Tingkat Kd',
            'jam' => 'Jam',
            'ttd_was_17' => 'Ttd Was 17',
            'ttd_peg_nik' => 'Ttd Peg Nik',
            'ttd_id_jabatan' => 'Ttd Id Jabatan',
            'upload_file' => 'Upload File',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'perihal' => 'Perihal',
        ];
    }
}
