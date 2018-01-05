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
class Terlapor extends \yii\db\ActiveRecord
{
    // public $nama_wilayah;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.terlapor_awal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pelanggaran_terlapor_awal'], 'string'],
            [['nama_terlapor_awal','level_was'], 'string', 'max' => 30],
            [['jabatan_terlapor_awal', 'satker_terlapor_awal'], 'string', 'max' => 65],
            [['tgl_pelanggaran_terlapor_awal', 'bln_pelanggaran_terlapor_awal'], 'string', 'max' => 2],
			// [['id_unit_kejari', 'id_bidang_kejati', 'id_cabjari_kejadian'], 'string', 'max' => 3],
            [['thn_pelanggaran_terlapor_awal'], 'string', 'max' => 4],
            [['no_register'], 'string', 'max' => 25],
            [['id_inspektur'], 'integer'],
			[['satker_terlapor_awal','pelanggaran_terlapor_awal','thn_pelanggaran_terlapor_awal'], 'required'],
            /*tambahan permintaan kang putut 29-03-2017*/
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['id_tingkat_kejadian','id_kejati_kejadian','id_kejati_kejadian','id_cabjari_kejadian'], 'string', 'max' => 2],
            [['id_level1','id_level2','id_level3','id_level4','created_by'], 'integer'],
            [['id_wilayah_kejadian','id_level1_kejadian','id_level2_kejadian'], 'integer'],
            [['no_urut'], 'integer'],
            [['created_ip'], 'string', 'max' => 15],
            [['created_time'], 'safe'],
			
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_terlapor_awal' => 'Id Terlapor Awal',
            'nama_terlapor_awal' => 'Nama Terlapor Awal',
            'jabatan_terlapor_awal' => 'Jabatan Terlapor Awal',
            'satker_terlapor_awal' => 'Satker Terlapor Awal',
            'pelanggaran_terlapor_awal' => 'Pelanggaran Terlapor Awal',
            'tgl_pelanggaran_terlapor_awal' => 'Tgl Pelanggaran Terlapor Awal',
            'bln_pelanggaran_terlapor_awal' => 'Bln Pelanggaran Terlapor Awal',
            'thn_pelanggaran_terlapor_awal' => 'Thn Pelanggaran Terlapor Awal',
            'no_register' => 'No Register',
            'id_wilayah' => 'Id Wilayah',
            // 'id_bidang_kejati' => 'Id Bidang Kejati',
            // 'id_unit_kejari' => 'Id Unit Kerja',
            // 'id_cabjari' => 'Id Cabjari',
            'id_inspektur' => 'ID Inspektur',
           /*  'irmud_pegasum_kepbang' => 'irmud_pegasum_kepbang',
            'irmud_pidum_datun' => 'irmud_pidum_datun',
			'irmud_intel_pidsus' => 'irmud_intel_pidsus', */
        ];
    }
}
