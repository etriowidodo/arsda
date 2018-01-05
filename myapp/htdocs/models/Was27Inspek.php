<?php

namespace app\models;

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
 * @property string $persetujuan
 * @property integer $ttd_was_27_inspek
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
class Was27Inspek extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_27_inspek';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_was_27_inspek'], 'required'],
            [['tgl', 'created_time', 'updated_time'], 'safe'],
            [['sifat_surat', 'jml_lampiran', 'satuan_lampiran', 'rncn_henti_riksa_1_was_27_ins', 'rncn_henti_riksa_2_was_27_ins', 'pendapat_1_was_27_ins', 'ttd_was_27_inspek', 'ttd_peg_jabatan', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['id_was_27_inspek', 'id_register', 'no_was_27_inspek', 'ttd_peg_nik', 'ttd_peg_nip'], 'string', 'max' => 20],
            [['inst_satkerkd', 'ttd_peg_nrp'], 'string', 'max' => 10],
            [['data_data', 'analisa', 'kesimpulan', 'pendapat', 'persetujuan'], 'string', 'max' => 2000],
            [['upload_file_data', 'upload_file'], 'string', 'max' => 200],
            [['ttd_peg_gol'], 'string', 'max' => 5],
            [['ttd_peg_inst_satker', 'ttd_peg_unitkerja'], 'string', 'max' => 12],
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
