<?php

namespace app\modules\pengawasan\models;

use Yii;

class Was11InspeksiSaksiEks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $cari ;
    public static function tableName()
    {
        return 'was.was11_inspeksi_saksi_ext';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
    return [
   // [['id_was10'], 'required'],

    [['tanggal_pemeriksaan','jam_pemeriksaan','created_time','updated_time'], 'safe'],
    [['id_was_11','id_was_9','created_by','updated_by','id_sp_was2','id_was_11_saksi_ext'], 'integer'],
    [['golongan_pemeriksa'], 'string', 'max' => 50],
    [['nama_pemeriksa'], 'string', 'max' => 65],
   // [['pangkat_saksi_internal'], 'string', 'max' => 30],
    [['nip_pemeriksa'], 'string', 'max' => 18],
    [['jabatan_pemeriksa','pangkat_pemeriksa','tempat_pemeriksaan',
      'alamat_saksi_eksternal','nama_saksi_eksternal','nama_kota_saksi_eksternal'], 'string', 'max' => 100],
    [['satker_pemeriksaan'], 'string', 'max' => 70],
    [['hari_pemeriksaan'], 'string', 'max' => 20],
    [['created_ip','updated_ip'], 'string', 'max' => 15],
    [['nrp_pemeriksa'], 'string', 'max' => 10],
    //[['is_inspektur_irmud_riksa'], 'string', 'max' => 4],
    [['no_register'], 'string', 'max' => 25],
    [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
    [['id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_11_detail_int' => 'Id Was11 detail',
            
        ];
    }
}
