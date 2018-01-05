<?php

namespace app\modules\pengawasan\models;

use Yii;

class BaWas4Inspeksi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public $cari;
     public $negara_eks;
     public $agama_eks;
     public $pendidikan_eks;
     //public $tmpt_lahir;
    public static function tableName()
    {
        return 'was.ba_was_4_inspeksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id_ba_was_4'], 'required'],
            [['created_time', 'updated_time', 'tanggal_ba_was_4'], 'safe'],
            [['created_by', 'updated_by','id_ba_was4','id_saksi_eksternal','pendidikan_saksi_eksternal'], 'integer'],
            [['tanggal_lahir_saksi_eksternal'], 'safe'],
            [['id_agama_saksi_eksternal', 'id_negara_saksi_eksternal'], 'integer'],
            [['no_register'], 'string', 'max' => 25],
            [['nama_kota_saksi_eksternal'], 'string', 'max' => 25],
            [['created_ip','updated_ip'], 'string', 'max' => 15],
            [['nama_saksi_eksternal'], 'string', 'max' => 20],
            [['file_ba_was_4'], 'string', 'max' => 200],
            [['tempat_ba_was_4'], 'string', 'max' => 50],
            [['tempat_lahir_saksi_eksternal'], 'string', 'max' => 60],
            [['pekerjaan_saksi_eksternal','alamat_saksi_eksternal'], 'string', 'max' => 100],
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
            'id_ba_was4' => 'Id Ba Was 4',
        ];
    }

    /**
     * @inheritdoc
     * @return Query the active query used by this AR class.
     */
   /*  public static function find()
    {
        return new Query(get_called_class());
    } */
}
