<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_sp_was_2".
 *
 * @property string $kejaksaan
 * @property string $pejabat_sp_was_2
 * @property string $no_sp_was_2
 * @property string $perja
 * @property string $tgl_berlaku_1
 * @property string $tgl_berlaku_2
 * @property string $anggaran
 * @property string $thn_dipa
 * @property string $tgl_sp_was_2
 * @property string $ttd_peg_nip
 * @property string $ttd_peg_nama
 * @property string $ttd_jabatan
 * @property string $id_register
 * @property string $id_sp_was_2
 */
class VSpWas2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_sp_was2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tanggal_sp_was2','tanggal_mulai_sp_was2,', 'tanggal_akhir_sp_was2'], 'safe'],
            [['nip_penandatangan'], 'string', 'max' => 18],
            [['nama_penandatangan'], 'string', 'max' => 30],
            [['pangkat_penandatangan'], 'string', 'max' => 5],
            [['golongan_penandatangan','jabatan_penandatangan','jbtn_penandatangan'], 'string', 'max' => 65],
            [['id_sp_was2'], 'string', 'max' => 16],
            [['status_penandatangan','no_register'], 'string', 'max' => 25],
            [['inst_nama'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            // 'kejaksaan' => 'Kejaksaan',
            // 'nama_penandatangan_spwas2' => 'Pejabat Sp Was 2',
            // 'no_sp_was_2' => 'No Sp Was 2',
            // 'perja' => 'Perja',
            // 'tgl_berlaku_1' => 'Tgl Berlaku 1',
            // 'tgl_berlaku_2' => 'Tgl Berlaku 2',
            // 'anggaran' => 'Anggaran',
            // 'jabatan_penandatangan_spwas2' => 'Thn Dipa',
            // 'tgl_sp_was_2' => 'Tgl Sp Was 2',
            // 'ttd_peg_nip' => 'Ttd Peg Nip',
            // 'no_register' => 'Ttd Peg Nama',
            // 'ttd_jabatan' => 'Ttd Jabatan',
            // 'status_penandatangan' => 'Id Register',
            // 'id_sp_was_2' => 'Id Sp Was 2',
        ];
    }
}
