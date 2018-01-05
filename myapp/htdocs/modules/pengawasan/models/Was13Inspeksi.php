<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was13".
 *
 * @property string $id_was13
 * @property string $id_surat
 * @property string $no_surat
 * @property string $nama_pengirim
 * @property string $tanggal_dikirim
 * @property string $nama_penerima
 * @property string $tanggal_diterima
 * @property string $was13_file
 * @property string $nama_surat
 * @property string $tanggal_surat
 * @property string $dari
 * @property string $kepada
 */
class Was13Inspeksi extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was13_inspeksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id_was13'], 'required'],
            [['tanggal_dikirim', 'tanggal_diterima','tanggal_surat'], 'safe'],
            [['id_was13','id_was12','id_was11','id_was10','id_was9',
              'id_sp_was2','created_by','updated_by'], 'integer'],
            [['created_ip','updated_ip'], 'string', 'max' => 15],
            [['created_time','updated_time'], 'safe'],
            [['nrp_pengirim','nrp_penerima'], 'string', 'max' => 10],
            [['nip_pengirim','nip_penerima'], 'string', 'max' => 18],
            [['was13_file'], 'string', 'max' => 30],
            [['nama_surat'], 'string', 'max' => 6],
           // [['is_inspektur_irmud_riksa'], 'string', 'max' => 4],
            [['no_surat_was13','golongan_pengirim','pangkat_pengirim','golongan_penerima','pangkat_penerima'], 'string', 'max' => 50],
            [['id_tingkat','id_kejati','id_kejari','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
            [['no_register'], 'string', 'max' => 25],    
            [['dari','kepada','jabatan_pengirim','jabatan_penerima','nama_pengirim', 'nama_penerima'], 'string', 'max' => 100],            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was13' => 'Id Was13',
            'id_surat' => 'Id Surat',
            'no_surat_was13' => 'No Surat Was13',
            'no_register' => 'no register',
            'nama_pengirim' => 'Nama Pengirim',
            'tanggal_dikirim' => 'Tanggal Dikirim',
            'nama_penerima' => 'Nama Penerima',
            'tanggal_diterima' => 'Tanggal Diterima',
            'was13_file' => 'Was13 File',
            'nama_surat' => 'Nama Surat',
            'tanggal_surat' => 'Tanggal Surat',
            'dari' => 'dari',
            'kepada' => 'kepada',
        ];
    }
}
