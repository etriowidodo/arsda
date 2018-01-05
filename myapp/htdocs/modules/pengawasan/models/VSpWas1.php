<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_sp_was_1".
 *
 * @property string $kejaksaan
 * @property string $pejabat_sp_was_1
 * @property string $no_sp_was_1
 * @property string $perja
 * @property string $tgl_berlaku_1
 * @property string $tgl_berlaku_2
 * @property string $anggaran
 * @property string $thn_dipa
 * @property string $tgl_sp_was_1
 * @property string $ttd_peg_nip
 * @property string $ttd_peg_nama
 * @property string $ttd_jabatan
 * @property string $id_register
 * @property string $id_sp_was_1
 */
class VSpWas1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_sp_was1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tanggal_sp_was1','tanggal_mulai_sp_was1,', 'tanggal_akhir_sp_was1'], 'safe'],
            [['nip_penandatangan'], 'string', 'max' => 18],
            [['nama_penandatangan'], 'string', 'max' => 30],
            [['pangkat_penandatangan'], 'string', 'max' => 5],
            [['golongan_penandatangan','jabatan_penandatangan','jbtn_penandatangan'], 'string', 'max' => 65],
            [['id_sp_was1'], 'string', 'max' => 16],
            [['status_penandatangan','no_register'], 'string', 'max' => 25],
            [['inst_nama'], 'string', 'max' => 100],
        ];
    }
    /**
     * @inheritdoc
     */
   /*  public function attributeLabels()
    {
        return [
            'kejaksaan' => 'Kejaksaan',
            'pejabat_sp_was_1' => 'Pejabat Sp Was 1',
            'no_sp_was_1' => 'No Sp Was 1',
            'perja' => 'Perja',
            'tgl_berlaku_1' => 'Tgl Berlaku 1',
            'tgl_berlaku_2' => 'Tgl Berlaku 2',
            'anggaran' => 'Anggaran',
            'thn_dipa' => 'Thn Dipa',
            'tgl_sp_was_1' => 'Tgl Sp Was 1',
            'ttd_peg_nip' => 'Ttd Peg Nip',
            'ttd_peg_nama' => 'Ttd Peg Nama',
            'ttd_jabatan' => 'Ttd Jabatan',
            'id_register' => 'Id Register',
            'id_sp_was_1' => 'Id Sp Was 1',
			'gol_pangkat' => 'Pangkat',
        ];
    } */
}
