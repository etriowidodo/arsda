<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.sp_was_2".
 *
 * @property string $id_sp_was_2
 * @property string $no_sp_was_2
 * @property string $inst_satkerkd
 * @property string $id_register
 * @property string $tgl_sp_was_2
 * @property integer $ttd_sp_was_2
 * @property string $perja
 * @property string $tgl_1
 * @property string $tgl_2
 * @property integer $anggaran
 * @property string $thn_dipa
 * @property string $ttd_peg_nik
 * @property string $ttd_id_jabatan
 * @property string $upload_file
 * @property integer $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */



class SpWas2 extends \yii\db\ActiveRecord
{
    // public $no_register;
    // public $inst_nama;
    // public $ttd_peg_nama;
    // public $ttd_peg_nip;
    // public $ttd_peg_pangkat;
    // public $ttd_peg_jabatan;
     public $cari;
     public $isi_dasar_sp_was_2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.sp_was_2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sp_was2','id_was_27', 'tanggal_sp_was2', 'tanggal_mulai_sp_was2','tanggal_akhir_sp_was2', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['nip_penandatangan'], 'string', 'max' => 18],
            [['pangkat_penandatangan','golongan_penandatangan','file_sp_was2'], 'string', 'max' => 30],
            [['jabatan_penandatangan','jbtn_penandatangan'], 'string', 'max' => 65],
            [['nomor_sp_was2'], 'string', 'max' => 50],
            [['nama_penandatangan'], 'string', 'max' => 70],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
         //   [['id_was27'], 'string', 'max' => 50],

         //   [['inst_satkerkd'], 'string', 'max' => 10],
            [['no_register'], 'string', 'max' => 25],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['status_penandatangan'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_sp_was2' => 'Id Sp Was 2',
            'nomor_sp_was2' => 'No Sp Was 2',
            'id_was_27'  =>'Id Was27',
          //  'inst_satkerkd' => 'Inst Satkerkd',
            'id_register' => 'Id Register',
            'tgl_sp_was_2' => 'Tgl Sp Was 2',
            'ttd_sp_was_2' => 'Ttd Sp Was 2',
            'perja' => 'Perja',
            'tanggal_mulai_sp_was2' => 'Tgl 1',
            'tanggal_akhir_sp_was2' => 'Tgl 2',
            'anggaran' => 'Anggaran',
            'thn_dipa' => 'Thn Dipa',
            'ttd_peg_nik' => 'Ttd Peg Nik',
            'ttd_id_jabatan' => 'Ttd Id Jabatan',
            'file_sp_was2' => 'Upload File',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
