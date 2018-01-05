<?php

namespace app\modules\pengawasan\models;

use Yii;

class BaWas3DetailPemeriksa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.ba_was_3_detail_pemeriksa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'id_ba_was3','id_pemeriksa_ba_was3'], 'integer'],
            [['created_time'], 'safe'],
            [['no_register'], 'string', 'max' => 25],
            [['created_ip'], 'string', 'max' => 15],
            [['nip'], 'string', 'max' => 18],
            [['nrp'], 'string', 'max' => 10],
            [['pangkat_pemeriksa'], 'string', 'max' => 30],
            [['jabatan_pemeriksa','nama_pemeriksa'], 'string', 'max' => 100],
            [['golongan_pemeriksa'], 'string', 'max' => 20],
            [['id_tingkat','id_kejati','id_kejati','id_cabjari'], 'string', 'max' => 2],
            [['is_inspektur_irmud_riksa'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ba_was2' => 'Id Ba Was 3',
            'nip' => 'nip',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
        ];
    }
}
