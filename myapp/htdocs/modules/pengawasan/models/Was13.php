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
class Was13 extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was13';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id_was13'], 'required'],
            [['id_was13'], 'integer'],
            [['tanggal_dikirim', 'tanggal_diterima','tanggal_surat'], 'safe'],
            [['nrp_pengirim','nrp_penerima'], 'string', 'max' => 10],
            [['nip_pengirim','nip_penerima'], 'string', 'max' => 18],
            [['id_surat','no_register'], 'string', 'max' => 25],
            [['nama_pengirim', 'nama_penerima', 'was13_file'], 'string', 'max' => 30],
            [['nama_surat'], 'string', 'max' => 6],
            [['no_surat_was13','golongan_pengirim','pangkat_pengirim','golongan_penerima','pangkat_penerima'], 'string', 'max' => 50],            
            [['dari','kepada','jabatan_pengirim','jabatan_penerima'], 'string', 'max' => 100],            
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
