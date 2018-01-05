<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was_11".
 *
 * @property string $id_surat_was11
 * @property string $no_was_11
 * @property string $no_register
 * @property string $tgl_was_11
 * @property integer $sifat_surat
 * @property integer $lampiran_was11
 * @property string $perihal
 * @property string $upload_file
 * @property string $kepada_was11
 * @property string $di_was11
 * @property string $nip_penandatangan
 * @property string $nama_penandatangan
 * @property string $pangkat_penandatangan
 * @property string $golongan_penandatangan
 * @property string $jabatan_penandatangan
 */
class Was11 extends \yii\db\ActiveRecord
{
    public $cari;
    // public $jenis_saksi;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was11';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id_surat_was11'], 'required'],
            [['tgl_was_11'], 'safe'],
            [['sifat_surat','id_surat_was11'], 'integer'],
            [['no_was_11'], 'string', 'max' => 50],
            [['kepada_was11'], 'string', 'max' => 65],
            [['lampiran_was11'], 'string', 'max' => 10],
            [['no_register'], 'string', 'max' => 25],
            [['perihal'], 'string', 'max' => 1000],
			 [['nama_penandatangan'], 'string', 'max' => 100],
            [['upload_file','nama_penandatangan'], 'string', 'max' => 200],
            [['di_was11'], 'string', 'max' => 11],
            // [['is_inspektur_irmud_riksa','status_penandatangan'], 'string', 'max' => 4],
            [['jenis_saksi'], 'string', 'max' => 9],
            [['nip_penandatangan'], 'string', 'max' => 18],
            [['pangkat_penandatangan'], 'string', 'max' => 30],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
            [['golongan_penandatangan', 'jabatan_penandatangan','jbtn_penandatangan'], 'string', 'max' => 65]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_surat_was11' => 'Id Was 11',
            'no_was_11' => 'No Was 11',
            'no_register' => 'No Register',
            'tgl_was_11' => 'Tgl Was 11',
            'sifat_surat' => 'Sifat Surat',
            'lampiran_was11' => 'Lampiran Was11',
            'perihal' => 'Perihal',
            'upload_file' => 'Upload File',
            'kepada_was11' => 'Kepada Was11',
            'di_was11' => 'Di Was11',
            'nip_penandatangan' => 'Nip Penandatangan',
            'nama_penandatangan' => 'Nama Penandatangan',
            'pangkat_penandatangan' => 'Pangkat Penandatangan',
            'golongan_penandatangan' => 'Golongan Penandatangan',
            'jabatan_penandatangan' => 'Jabatan Alias Penandatangan',
            'jbtn_penandatangan' => 'Jabatan Penandatangan',
        ];
    }
}
