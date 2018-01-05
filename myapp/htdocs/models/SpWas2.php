<?php

namespace app\models;

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
 * @property integer $saran
 * @property string $thn_dipa
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
class SpWas2 extends \yii\db\ActiveRecord
{
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
            [['id_sp_was_2'], 'required'],
            [['tgl_sp_was_2', 'tgl_1', 'tgl_2', 'created_time', 'updated_time'], 'safe'],
            [['ttd_sp_was_2', 'anggaran', 'saran', 'ttd_peg_jabatan', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['id_sp_was_2', 'no_sp_was_2', 'id_register', 'perja', 'ttd_peg_nik', 'ttd_peg_nip'], 'string', 'max' => 20],
            [['inst_satkerkd', 'ttd_peg_nrp'], 'string', 'max' => 10],
            [['thn_dipa'], 'string', 'max' => 4],
            [['ttd_peg_gol'], 'string', 'max' => 5],
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
            'id_sp_was_2' => 'Id Sp Was 2',
            'no_sp_was_2' => 'No Sp Was 2',
            'inst_satkerkd' => 'Inst Satkerkd',
            'id_register' => 'Id Register',
            'tgl_sp_was_2' => 'Tgl Sp Was 2',
            'ttd_sp_was_2' => 'Ttd Sp Was 2',
            'perja' => 'Perja',
            'tgl_1' => 'Tgl 1',
            'tgl_2' => 'Tgl 2',
            'anggaran' => 'Anggaran',
            'saran' => 'Saran',
            'thn_dipa' => 'Thn Dipa',
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
