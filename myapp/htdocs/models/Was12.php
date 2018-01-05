<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.was_12".
 *
 * @property string $id_was_12
 * @property string $no_was_12
 * @property string $inst_satkerkd
 * @property string $id_register
 * @property string $tgl_was_12
 * @property integer $sifat_surat
 * @property integer $jml_lampiran
 * @property integer $satuan_lampiran
 * @property string $perihal
 * @property string $hari
 * @property string $tgl
 * @property string $jam
 * @property string $tempat
 * @property integer $id_pemeriksa
 * @property integer $ttd_was_12
 * @property string $ttd_peg_nik
 * @property string $ttd_peg_nip
 * @property string $ttd_peg_nrp
 * @property string $ttd_peg_gol
 * @property integer $ttd_peg_jabatan
 * @property string $ttd_peg_inst_satker
 * @property string $ttd_peg_unitkerja
 * @property string $upload_file
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class Was12 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_12';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_was_12'], 'required'],
            [['tgl_was_12', 'tgl', 'created_time', 'updated_time'], 'safe'],
            [['sifat_surat', 'jml_lampiran', 'satuan_lampiran', 'id_pemeriksa', 'ttd_was_12', 'ttd_peg_jabatan', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['id_was_12', 'no_was_12', 'id_register', 'perihal', 'ttd_peg_nik', 'ttd_peg_nip'], 'string', 'max' => 20],
            [['inst_satkerkd', 'hari', 'ttd_peg_nrp'], 'string', 'max' => 10],
            [['jam', 'ttd_peg_gol'], 'string', 'max' => 5],
            [['tempat'], 'string', 'max' => 60],
            [['ttd_peg_inst_satker', 'ttd_peg_unitkerja'], 'string', 'max' => 12],
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
            'id_was_12' => 'Id Was 12',
            'no_was_12' => 'No Was 12',
            'inst_satkerkd' => 'Inst Satkerkd',
            'id_register' => 'Id Register',
            'tgl_was_12' => 'Tgl Was 12',
            'sifat_surat' => 'Sifat Surat',
            'jml_lampiran' => 'Jml Lampiran',
            'satuan_lampiran' => 'Satuan Lampiran',
            'perihal' => 'Perihal',
            'hari' => 'Hari',
            'tgl' => 'Tgl',
            'jam' => 'Jam',
            'tempat' => 'Tempat',
            'id_pemeriksa' => 'Id Pemeriksa',
            'ttd_was_12' => 'Ttd Was 12',
            'ttd_peg_nik' => 'Ttd Peg Nik',
            'ttd_peg_nip' => 'Ttd Peg Nip',
            'ttd_peg_nrp' => 'Ttd Peg Nrp',
            'ttd_peg_gol' => 'Ttd Peg Gol',
            'ttd_peg_jabatan' => 'Ttd Peg Jabatan',
            'ttd_peg_inst_satker' => 'Ttd Peg Inst Satker',
            'ttd_peg_unitkerja' => 'Ttd Peg Unitkerja',
            'upload_file' => 'Upload File',
            'is_deleted' => 'Is Deleted',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
