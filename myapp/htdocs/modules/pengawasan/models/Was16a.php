<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_16a".
 *
 * @property string $id_was_16a
 * @property string $no_was_16a
 * @property string $id_register
 * @property string $inst_satkerkd
 * @property integer $kpd_was_16a
 * @property string $id_terlapor
 * @property string $tgl_was_16a
 * @property integer $sifat_surat
 * @property integer $jml_lampiran
 * @property integer $satuan_lampiran
 * @property string $perihal
 * @property integer $ttd_was_16a
 * @property string $ttd_peg_nik
 * @property string $ttd_id_jabatan
 * @property string $upload_file
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class Was16a extends \yii\db\ActiveRecord
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
        return 'was.Was_16a';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kpd_was_16a', 'sifat_surat', 'jml_lampiran', 'satuan_lampiran', 'ttd_was_16a', 'created_by', 'updated_by'], 'integer'],
            [['tgl_was_16a', 'created_time', 'updated_time'], 'safe'],
            [['ttd_peg_nik'], 'string', 'max' => 20],
            [['no_was_16a'], 'string', 'max' => 50],
            [['id_register', 'id_terlapor', 'ttd_id_jabatan'], 'string', 'max' => 16],
            [['inst_satkerkd'], 'string', 'max' => 10],
            [['perihal'], 'string', 'max' => 1000],
            [['upload_file'], 'string', 'max' => 200],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_16a' => 'Id Was 16a',
            'no_was_16a' => 'No Was 16a',
            'id_register' => 'Id Register',
            'inst_satkerkd' => 'Inst Satkerkd',
            'kpd_was_16a' => 'Kpd Was 16a',
            'id_terlapor' => 'Id Terlapor',
            'tgl_was_16a' => 'Tgl Was 16a',
            'sifat_surat' => 'Sifat Surat',
            'jml_lampiran' => 'Jml Lampiran',
            'satuan_lampiran' => 'Satuan Lampiran',
            'perihal' => 'Perihal',
            'ttd_was_16a' => 'Ttd Was 16a',
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
