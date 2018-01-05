<?php

namespace app\modules\pengawasan\models;

use Yii;


class Was27Klari extends WasRecord
{
    public $inst_nama;
    public $flag;
    public $uraian;
    // public $ttd_was_27_klari;
    // public $ttd_peg_nip;
    public $ttd_peg_pangkat;
    public $ttd_peg_jabatan;
    public $kepadayth;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_27_klari';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl','tgl_lapdu', 'created_time', 'updated_time'], 'safe'],
            [['sifat_surat','created_by', 'updated_by','id_sp_was'], 'integer'],
            [['no_register'], 'string', 'max' => 16],
            [['perihal'], 'string', 'max' => 100],
            [['nip_penandatangan', 'jml_lampiran'], 'string', 'max' => 20],
            [['no_was_27_klari','nama_penandatangan','nomor_surat_lapdu'], 'string', 'max' => 50],
            [['analisa', 'kesimpulan', 'permasalahan', 'data_data'], 'string', 'max' => 2000],
            [['upload_file_data'], 'string', 'max' => 200],
            [['kepada','dari'], 'string', 'max' => 200],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['jabatan_penandatangan'], 'string', 'max' => 65],
            [['persetujuan'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_27_klari' => 'Id Was 27 Klari',
            'id_register' => 'Id Register',
            'inst_satkerkd' => 'Inst Satkerkd',
            'no_was_27_klari' => 'No Was 27 Klari',
            'tgl' => 'Tgl',
            'sifat_surat' => 'Sifat Surat',
            'jml_lampiran' => 'Jml Lampiran',
            'upload_file_data' => 'Upload File Data',
            'analisa' => 'Analisa',
            'kesimpulan' => 'Kesimpulan',
            'data_data' => 'Rncn Henti Riksa 1 Was 27 Kla',
            'permasalahan' => 'Rncn Henti Riksa 2 Was 27 Kla',
            // 'persetujuan' => 'Persetujuan',
            // 'ttd_was_27_klari' => 'Ttd Was 27 Klari',
            'ttd_peg_nik' => 'Ttd Peg Nik',
            'ttd_id_jabatan' => 'Ttd Id Jabatan',
            // 'upload_file' => 'Upload File',
            // 'flag' => 'Is Deleted',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
