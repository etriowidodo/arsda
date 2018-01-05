<?php

namespace app\modules\pengawasan\models;

use Yii;


class BaWas2InspeksiKesimpulan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.ba_was_2_inspeksi_kesimpulan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'id_ba_was2','id_ba_was_2_kesimpulan'], 'integer'],
            [['created_time'], 'safe'],
            [['no_register'], 'string', 'max' => 25],
            [['kesimpulan_ba_was_2'], 'string', 'max' => 2000],
            [['created_ip'], 'string', 'max' => 15],
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
            'kesimpulan_ba_was_2' => 'Hasil',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
        ];
    }
}
