<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.terlapor_1".
 *
 * @property integer $id_terlapor_awal
 * @property string $nama_terlapor_awal
 * @property string $jabatan_terlapor_awal
 * @property string $satker_terlapor_awal
 * @property string $pelanggaran_terlapor_awal
 * @property string $tgl_pelanggaran_terlapor_awal
 * @property string $bln_pelanggaran_terlapor_awal
 * @property string $thn_pelanggaran_terlapor_awal
 * @property string $no_register
 * @property string $id_wilayah
 * @property string $id_bidang_kejati
 * @property string $id_unit_kejari
 * @property string $id_cabjari
 */
class PegawaiTerlaporWas10Inspeksi extends \yii\db\ActiveRecord
{
    // public $id_terlapor;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.pegawai_terlapor_was10_inspeksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id_pegawai_terlapor'], 'string','max' => 7],
            [['nip_pegawai_terlapor'], 'string', 'max' => 18],
			[['nrp_pegawai_terlapor'], 'string', 'max' => 10],
			[['pangkat_pegawai_terlapor'], 'string', 'max' => 30],
            [['jabatan_pegawai_terlapor', 'satker_pegawai_terlapor','nama_pegawai_terlapor'], 'string', 'max' => 100],
            [['golongan_pegawai_terlapor'], 'string', 'max' => 50],
            [['no_register'], 'string', 'max' => 25],
			[['created_ip'], 'string', 'max' => 15],
            [['created_time'], 'safe'],
			// [['satker_pegawai_terlapor'], 'required'],
            [['id_tingkat','id_kejati','id_kejari','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4','id_sp_was2'], 'integer'],
            [['id_pegawai_terlapor','created_by'], 'integer'],
			
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pegawai_terlapor' => 'ID Pegawai Terlapor',
            'nip' => 'NIP',
            'nrp_pegawai_terlapor' => 'NRP Pegawai Terlapor',
            'nama_pegawai_terlapor' => 'Nama Pegawai Terlapor',
            'pangkat_pegawai_terlapor' => 'Pangkat Pegawai Terlapor',
            'jabatan_pegawai_terlapor' => 'Jabatan Pegawai Terlapor',
            'satker_pegawai_terlapor' => 'Satker Pegawai Terlapor',
            'golongan_pegawai_terlapor' => 'Golongan Pegawai Terlapor',
            // 'id_sp_was' => 'Id SP-Was',
            'no_register' => 'No Register',
        ];
    }
}
