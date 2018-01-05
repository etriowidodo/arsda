<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_was_15".
 *
 * @property string $id_was_15
 * @property string $no_was_15
 * @property string $id_register
 * @property string $inst_satkerkd
 * @property string $tgl_was_15
 * @property integer $sifat_surat
 * @property integer $jml_lampiran
 * @property integer $satuan_lampiran
 * @property integer $rncn_jatuh_hukdis_1_was_15
 * @property integer $rncn_jatuh_hukdis_2_was_15
 * @property integer $rncn_jatuh_hukdis_3_was_15
 * @property string $pendapat
 * @property integer $persetujuan
 * @property integer $ttd_was_15
 * @property string $ttd_peg_nik
 * @property string $ttd_id_jabatan
 * @property string $upload_file
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $kepada
 * @property string $nomor_surat
 * @property string $tgl_surat
 * @property string $ttd_peg_nama
 * @property string $ttd_peg_jabatan
 * @property string $ttd_peg_nip
 * @property string $kejaksaan
 * @property string $sifat
 */
class VWas15 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_was_15';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_was_15', 'created_time', 'updated_time', 'tgl_surat'], 'safe'],
            [['kepada','sifat_surat', 'jml_lampiran', 'satuan_lampiran', 'rncn_jatuh_hukdis_1_was_15', 'rncn_jatuh_hukdis_2_was_15', 'rncn_jatuh_hukdis_3_was_15', 'persetujuan', 'ttd_was_15', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['ttd_peg_jabatan'], 'string'],
            [['id_was_15', 'id_register', 'ttd_id_jabatan'], 'string', 'max' => 16],
            [['no_was_15', 'ttd_peg_nik', 'nomor_surat', 'ttd_peg_nip'], 'string', 'max' => 20],
            [['inst_satkerkd'], 'string', 'max' => 10],
            [['pendapat'], 'string', 'max' => 2000],
            [['upload_file'], 'string', 'max' => 200],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['ttd_peg_nama'], 'string', 'max' => 65],
            [['kejaksaan'], 'string', 'max' => 100],
            [['sifat'], 'string', 'max' => 225]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_15' => 'Id Was 15',
            'no_was_15' => 'No Was 15',
            'id_register' => 'Id Register',
            'inst_satkerkd' => 'Inst Satkerkd',
            'tgl_was_15' => 'Tgl Was 15',
            'sifat_surat' => 'Sifat Surat',
            'jml_lampiran' => 'Jml Lampiran',
            'satuan_lampiran' => 'Satuan Lampiran',
            'rncn_jatuh_hukdis_1_was_15' => 'Rncn Jatuh Hukdis 1 Was 15',
            'rncn_jatuh_hukdis_2_was_15' => 'Rncn Jatuh Hukdis 2 Was 15',
            'rncn_jatuh_hukdis_3_was_15' => 'Rncn Jatuh Hukdis 3 Was 15',
            'pendapat' => 'Pendapat',
            'persetujuan' => 'Persetujuan',
            'ttd_was_15' => 'Ttd Was 15',
            'ttd_peg_nik' => 'Ttd Peg Nik',
            'ttd_id_jabatan' => 'Ttd Id Jabatan',
            'upload_file' => 'Upload File',
            'is_deleted' => 'Is Deleted',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'nomor_surat' => 'Nomor Surat',
            'tgl_surat' => 'Tgl Surat',
            'ttd_peg_nama' => 'Ttd Peg Nama',
            'ttd_peg_jabatan' => 'Ttd Peg Jabatan',
            'ttd_peg_nip' => 'Ttd Peg Nip',
            'kejaksaan' => 'Kejaksaan',
            'sifat' => 'Sifat',
            'kepada' => 'Kepada',
        ];
    }
}
