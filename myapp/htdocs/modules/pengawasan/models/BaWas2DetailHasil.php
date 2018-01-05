<?php

namespace app\modules\pengawasan\models;

use Yii;


class BaWas2DetailHasil extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.ba_was_2_detail_hasil';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'id_ba_was2','no_urut_hasil'], 'integer'],
            [['created_time'], 'safe'],
            [['no_register'], 'string', 'max' => 25],
            [['hasil_wawancara'], 'string', 'max' => 2000],
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
            'hasil_wawancara' => 'Hasil',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
        ];
    }
}
