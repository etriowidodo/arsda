<?php

namespace app\modules\pengawasan\models;

use Yii;

class BaWas2DetailEks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.ba_was2_detail_eks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'id_ba_was2','id_ba_was2_detail_eks','id_negara_saksi_eksternal'], 'integer'],
            [['created_time','tanggal_lahir_saksi_eksternal','pendidikan','id_agama_saksi_eksternal','id_warganegara'], 'safe'],
            [['no_register'], 'string', 'max' => 25],
            [['created_ip'], 'string', 'max' => 15],
            [['nama_saksi_eksternal'], 'string', 'max' => 50],
            [['tempat_lahir_saksi_eksternal'], 'string', 'max' => 60],
            [['alamat_saksi_eksternal','nama_kota_saksi_eksternal','pekerjaan_saksi_eksternal'], 'string', 'max' => 100],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ba_was2_detail_eks' => 'Id Ba Was 2',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
        ];
    }
}
