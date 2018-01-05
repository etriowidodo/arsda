<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_12".
 *
 * @property string $id_was10
 * @property string $id_was_12
 * @property string $tanggal_was12
 * @property string $perihal_was12
 * @property string $lampiran_was12
 * @property string $kepada_was12
 * @property string $di_was12
 * @property string $nip_penandatangan
 * @property string $nama_penandatangan
 * @property string $pangkat_penandatangan
 * @property string $golongan_penandatangan
 * @property string $jabatan_penandatangan
 * @property string $was12_file
 * @property integer $sifat_surat
 * @property string $jbtn_penandatangan
 * @property string $no_surat
 * @property string $inst_satkerkd
 */
class Was12Inspeksi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $cari ;
    public static function tableName()
    {
        return 'was.was12_inspeksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['id_was10'], 'required'],
            [['tanggal_was12','updated_time','created_time'], 'safe'],
            [['perihal_was12'], 'string'],
            [['sifat_surat', 'id_was_12','id_sp_was2','created_by','updated_by'], 'integer'],
            [['no_register'], 'string', 'max' => 25],
            [['created_ip','updated_ip'], 'string', 'max' => 25],
            [['lampiran_was12'], 'string', 'max' => 20],
            [['no_surat_was12'], 'string', 'max' => 50],
            [['kepada_was12', 'jabatan_penandatangan'], 'string', 'max' => 65],
            [['di_was12', 'pangkat_penandatangan', 'was12_file'], 'string', 'max' => 30],
            [['nip_penandatangan'], 'string', 'max' => 18],
            [['nama_penandatangan', 'jbtn_penandatangan'], 'string', 'max' => 100],
            [['golongan_penandatangan'], 'string', 'max' => 5],
            [['id_tingkat','id_kejati','id_kejari','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was10' => 'Id Was10',
            'id_was_12' => 'Id Was 12',
            'tanggal_was12' => 'Tanggal Was12',
            'perihal_was12' => 'Perihal Was12',
            'lampiran_was12' => 'Lampiran Was12',
            'kepada_was12' => 'Kepada Was12',
            'di_was12' => 'Di Was12',
            'nip_penandatangan' => 'Nip Penandatangan',
            'nama_penandatangan' => 'Nama Penandatangan',
            'pangkat_penandatangan' => 'Pangkat Penandatangan',
            'golongan_penandatangan' => 'Golongan Penandatangan',
            'jabatan_penandatangan' => 'Jabatan Penandatangan',
            'was12_file' => 'Was12 File',
            'sifat_surat' => 'Sifat Surat',
            'jbtn_penandatangan' => 'Jbtn Penandatangan',
            'no_surat' => 'No Surat',
        ];
    }
}
