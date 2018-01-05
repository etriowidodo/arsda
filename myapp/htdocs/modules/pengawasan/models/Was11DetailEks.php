<?php

namespace app\modules\pengawasan\models;

use Yii;

class Was11DetailEks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $cari ;
    public static function tableName()
    {
        return 'was.was_11_detail_eks';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
    return [
   // [['id_was10'], 'required'],
    [['tanggal_pemeriksaan','jam_pemeriksaan','created_time','updated_time'], 'safe'],
    [['id_was_11_detail_eks', 'id_was_11','id_was_9','created_by','updated_by'], 'integer'],
    [['no_register'], 'string', 'max' => 25],
    [['golongan_pemeriksa'], 'string', 'max' => 50],
    [['nama_pemeriksa'], 'string', 'max' => 65],
    [['nip_pemeriksa'], 'string', 'max' => 18],
    [['jabatan_pemeriksa','pangkat_pemeriksa','tempat_pemeriksaan','nama_saksi_eksternal','alamat_saksi_eksternal'], 'string', 'max' => 100],
    [['hari_pemeriksaan'], 'string', 'max' => 20],
    [['created_ip','updated_ip'], 'string', 'max' => 15],
    [['nrp_pemeriksa'], 'string', 'max' => 10],
    [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_11_detail_eks' => 'Id Was11 detail',
            
        ];
    }
}
