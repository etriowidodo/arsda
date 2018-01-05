<?php

namespace app\modules\pengawasan\models;
use app\models\MsWarganegara;
use Yii;

class Pelapor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.pelapor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
       
        return [
            [['id_sumber_laporan'], 'integer'],
            [['telp_pelapor'], 'string', 'max' => 13],
            [['alamat_pelapor'], 'string'],
            [['no_register'], 'string', 'max' => 25],
            [['nama_pelapor','email_pelapor','sumber_lainnya','agama_pelapor','pendidikan_pelapor','id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 30],
            [['pekerjaan_pelapor'], 'string', 'max' => 20],
            [['tempat_lahir_pelapor','kewarganegaraan_pelapor','nama_kota_pelapor'], 'string', 'max' => 50],
            [['tanggal_lahir_pelapor','created_time'], 'safe'],
            [['id_sumber_laporan'],'required'],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['id_wilayah','id_level1','id_level1','id_level1','id_level1','created_by'], 'integer'], 
            [['created_ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {

        return [
            'id_sumber_laporan' => 'Sumber Laporan',
            'telp_pelapor' => 'Telepon',
            'alamat_pelapor' => 'Alamat',
            'no_registrasi' => 'Nomor Registrasi',
            'nama_pelapor' => 'Nama Pelapor',
            'email_pelapor' => 'Email',
            'sumber_lainnya' => 'Sumber Lainya',
            'pekerjaan_pelapor' => 'Pekerjaan',
            'tempat_lahir_pelapor' => 'Tempat Lahir',
            'tanggal_lahir_pelapor' => 'Tanggal Lahir',
            'kewarganegaraan_pelapor' => 'Warga negara',
            'agama_pelapor' => 'Agama',
            'pendidikan_pelapor' => 'Pendidikan',
            'nama_kota_pelapor' => 'Kota',
            
        ];
    }
	public function getIdKewarganegaraanPelapor()
    {
        return $this->hasOne(MsWarganegara::className(), ['id' => 'kewarganegaraan_pelapor']);
    }
}
