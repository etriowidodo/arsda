<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_21".
 *
 * @property string $id_was_21
 * @property string $no_was_21
 * @property string $id_register
 * @property string $inst_satkerkd
 * @property string $tgl_was_21
 * @property integer $sifat_surat
 * @property integer $jml_lampiran
 * @property integer $satuan_lampiran
 * @property string $perihal
 * @property integer $kpd_was_21
 * @property integer $ttd_was_21
 * @property string $id_terlapor
 * @property integer $pendapat
 * @property integer $id_peraturan
 * @property string $tingkat_kd
 * @property integer $kputusan_ja
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
 */
class Was21 extends WasRecord
{
       public $no_register;
    public $inst_nama;
    public $ttd_peg_nama;
    public $ttd_peg_nip;
    public $ttd_peg_pangkat;
    public $ttd_peg_jabatan;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_21';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_was_21', 'created_time', 'updated_time'], 'safe'],
            [['sifat_surat', 'jml_lampiran', 'satuan_lampiran', 'kpd_was_21', 'ttd_was_21', 'pendapat', 'id_peraturan', 'kputusan_ja', 'ttd_id_jabatan'], 'integer'],
            [['ttd_peg_nik'], 'string', 'max' => 20],
            [['no_was_21'], 'string', 'max' => 50],
            [['id_register', 'id_terlapor'], 'string', 'max' => 16],
            [['inst_satkerkd'], 'string', 'max' => 10],
            [['perihal'], 'string', 'max' => 1000],
            [['tingkat_kd'], 'string', 'max' => 4],
            [['upload_file'], 'string', 'max' => 200],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 18]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_21' => 'Id Was 21',
            'no_was_21' => 'No Was 21',
            'id_register' => 'Id Register',
            'inst_satkerkd' => 'Inst Satkerkd',
            'tgl_was_21' => 'Tgl Was 21',
            'sifat_surat' => 'Sifat Surat',
            'jml_lampiran' => 'Jml Lampiran',
            'satuan_lampiran' => 'Satuan Lampiran',
            'perihal' => 'Perihal',
            'kpd_was_21' => 'Kpd Was 21',
            'ttd_was_21' => 'Ttd Was 21',
            'id_terlapor' => 'Id Terlapor',
            'pendapat' => 'Pendapat',
            'id_peraturan' => 'Id Peraturan',
            'tingkat_kd' => 'Tingkat Kd',
            'kputusan_ja' => 'Kputusan Ja',
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
        ];
    }
}
