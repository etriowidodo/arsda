<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_27_inspek".
 *
 * @property string $id_was_27_inspek
 * @property string $id_register
 * @property string $inst_satkerkd
 * @property string $no_was_27_inspek
 * @property string $tgl
 * @property integer $sifat_surat
 * @property integer $jml_lampiran
 * @property integer $satuan_lampiran
 * @property string $data_data
 * @property string $upload_file_data
 * @property string $analisa
 * @property string $kesimpulan
 * @property integer $rncn_henti_riksa_1_was_27_ins
 * @property integer $rncn_henti_riksa_2_was_27_ins
 * @property integer $pendapat_1_was_27_ins
 * @property string $pendapat
 * @property integer $persetujuan
 * @property integer $ttd_was_27_inspek
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
class Was27Inspek extends WasRecord
{
    
    public $inst_nama;
    public $no_register;
    public $uraian;
    public $ttd_peg_nama;
    public $ttd_peg_nip;
    public $ttd_peg_pangkat;
    public $ttd_peg_jabatan;
      public $kepadayth;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_27_inspeksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl', 'created_time', 'updated_time'], 'safe'],
            [['sifat_surat', 'jml_lampiran', 'satuan_lampiran', 'rncn_henti_riksa_1_was_27_ins', 'rncn_henti_riksa_2_was_27_ins', 'pendapat_1_was_27_ins', 'persetujuan', 'ttd_was_27_inspek', 'flag', 'created_by', 'updated_by'], 'integer'],
            [['id_register', 'ttd_id_jabatan'], 'string', 'max' => 16],
            [['inst_satkerkd'], 'string', 'max' => 10],
            [['ttd_peg_nik'], 'string', 'max' => 20],
            [['no_was_27_inspek'], 'string', 'max' => 50],
            [['data_data', 'analisa', 'kesimpulan', 'pendapat'], 'string', 'max' => 2000],
            [['upload_file_data', 'upload_file'], 'string', 'max' => 200],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_27_inspek' => 'Id Was 27 Inspek',
            'id_register' => 'Id Register',
            'inst_satkerkd' => 'Inst Satkerkd',
            'no_was_27_inspek' => 'No Was 27 Inspek',
            'tgl' => 'Tgl',
            'sifat_surat' => 'Sifat Surat',
            'jml_lampiran' => 'Jml Lampiran',
            'satuan_lampiran' => 'Satuan Lampiran',
            'data_data' => 'Data Data',
            'upload_file_data' => 'Upload File Data',
            'analisa' => 'Analisa',
            'kesimpulan' => 'Kesimpulan',
            'rncn_henti_riksa_1_was_27_ins' => 'Rncn Henti Riksa 1 Was 27 Ins',
            'rncn_henti_riksa_2_was_27_ins' => 'Rncn Henti Riksa 2 Was 27 Ins',
            'pendapat_1_was_27_ins' => 'Pendapat 1 Was 27 Ins',
            'pendapat' => 'Pendapat',
            'persetujuan' => 'Persetujuan',
            'ttd_was_27_inspek' => 'Ttd Was 27 Inspek',
            'ttd_peg_nik' => 'Ttd Peg Nik',
            'ttd_id_jabatan' => 'Ttd Id Jabatan',
            'upload_file' => 'Upload File',
            'flag' => 'Is Deleted',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
