<?php

namespace app\modules\pengawasan\models;

use Yii;

class Was11DetailInt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $cari ;
    public static function tableName()
    {
        return 'was.was_11_detail_int';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
    return [
   // [['id_was10'], 'required'],
    [['tanggal_pemeriksaan','jam_pemeriksaan','created_time','updated_time'], 'safe'],
    [['id_was_11_detail_int', 'id_was_11','id_was_9','created_by','updated_by','id_sp_was2','id_was11_saksi_int'], 'integer'],
    [['no_register'], 'string', 'max' => 25],
    [['golongan_saksi_internal','golongan_pemeriksa'], 'string', 'max' => 50],
    [['nama_saksi_internal','nama_pemeriksa'], 'string', 'max' => 65],
    [['pangkat_saksi_internal'], 'string', 'max' => 30],
    [['nip_saksi_internal','nip_pemeriksa'], 'string', 'max' => 18],
    [['jabatan_saksi_internal','jabatan_pemeriksa','pangkat_pemeriksa','tempat_pemeriksaan'], 'string', 'max' => 100],
    [['satker_pemeriksaan'], 'string', 'max' => 70],
    [['hari_pemeriksaan'], 'string', 'max' => 20],
    [['created_ip','updated_ip'], 'string', 'max' => 15],
    [['nrp_saksi_internal','nrp_pemeriksa'], 'string', 'max' => 10],
	[['is_inspektur_irmud_riksa'], 'string', 'max' => 4],
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
