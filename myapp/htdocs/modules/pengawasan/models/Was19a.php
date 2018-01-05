<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_19a".
 *
 * @property string $id_was_19a
 * @property string $no_was_19a
 * @property string $id_register
 * @property string $inst_satkerkd
 * @property string $tgl_was_19a
 * @property integer $sifat_surat
 * @property integer $jml_lampiran
 * @property integer $satuan_lampiran
 * @property integer $kpd_was_19a
 * @property string $id_terlapor
 * @property integer $ttd_was_19a
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
class Was19a extends WasRecord
{
    
        public $no_register;
    public $inst_nama;
    public $ttd_peg_nama;
    public $ttd_peg_nip;
    public $ttd_peg_pangkat;
    public $ttd_peg_jabatan;
    public $perihal;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_19a';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_was_19a', 'created_time', 'updated_time'], 'safe'],
            [['sifat_surat', 'jml_lampiran', 'satuan_lampiran', 'kpd_was_19a', 'ttd_was_19a', 'ttd_id_jabatan', 'created_by', 'updated_by'], 'integer'],
            [['ttd_peg_nik'], 'string', 'max' => 20],
            [['no_was_19a'], 'string', 'max' => 50],
            [['id_register', 'id_terlapor'], 'string', 'max' => 16],
            [['inst_satkerkd'], 'string', 'max' => 10],
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
            'id_was_19a' => 'Id Was 19a',
            'no_was_19a' => 'No Was 19a',
            'id_register' => 'Id Register',
            'inst_satkerkd' => 'Inst Satkerkd',
            'tgl_was_19a' => 'Tgl Was 19a',
            'sifat_surat' => 'Sifat Surat',
            'jml_lampiran' => 'Jml Lampiran',
            'satuan_lampiran' => 'Satuan Lampiran',
            'kpd_was_19a' => 'Kpd Was 19a',
            'id_terlapor' => 'Id Terlapor',
            'ttd_was_19a' => 'Ttd Was 19a',
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
