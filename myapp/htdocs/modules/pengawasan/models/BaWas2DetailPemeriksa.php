<?php

namespace app\modules\pengawasan\models;

use Yii;

class BaWas2DetailPemeriksa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.ba_was_2_detail_pemeriksa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'id_ba_was2','id_pemeriksa_ba_was2'], 'integer'],
            [['created_time'], 'safe'],
            [['no_register'], 'string', 'max' => 25],
            [['created_ip'], 'string', 'max' => 15],
            [['nip'], 'string', 'max' => 18],
            [['nrp'], 'string', 'max' => 10],
            [['pangkat_pemeriksa'], 'string', 'max' => 30],
            [['jabatan_pemeriksa','nama_pemeriksa'], 'string', 'max' => 100],
            [['golongan_pemeriksa'], 'string', 'max' => 20],
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
            'nip' => 'nip',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
        ];
    }
}
