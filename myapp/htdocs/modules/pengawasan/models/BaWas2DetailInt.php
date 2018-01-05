<?php

namespace app\modules\pengawasan\models;

use Yii;

class BaWas2DetailInt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.ba_was2_detail_int';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
         return [
            [['created_by', 'id_ba_was2','id_ba_was2_detail_int'], 'integer'],
            [['created_time'], 'safe'],
            [['no_register'], 'string', 'max' => 25],
            [['created_ip'], 'string', 'max' => 15],
            [['nip'], 'string', 'max' => 18],
            [['nrp'], 'string', 'max' => 10],
            [['pangkat_saksi_internal'], 'string', 'max' => 30],
            [['jabatan_saksi_internal','nama_saksi_internal'], 'string', 'max' => 100],
            [['golongan_saksi_internal'], 'string', 'max' => 20],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ba_was2' => 'Id Ba Was 2',
            'nip_saksi_internal' => 'nip',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
        ];
    }
}
