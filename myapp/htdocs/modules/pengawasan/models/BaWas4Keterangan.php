<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.ba_was_4_detail".
 *
 * @property string $id_ba_was_4_detail
 * @property string $id_ba_was_4
 * @property string $pernyataan
 * @property string $upload_file
 * @property integer $created_by
 * @property string $created_ip
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class BaWas4Keterangan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.ba_was_4_inspeksi_pernyataan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id_ba_was_4_detail'], 'required'],
            [['created_by', 'updated_by'], 'integer'],
            [['created_ip','updated_ip'], 'string', 'max' => 25],
            [['created_time','updated_time'], 'safe'],
            [['id_ba_was4_pernyataan', 'id_ba_was4','id_saksi_eksternal'], 'integer'],
            [['no_register'], 'string', 'max' => 25],
            [['pernyataan_ba_was_4'], 'string', 'max' => 2000],
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
            'id_ba_was4_pernyataan' => 'Id Ba Was 4 Detail',
            'id_ba_was4' => 'Id Ba Was 4',
            'pernyataan_ba_was_4' => 'Pernyataan',
            //'upload_file' => 'Upload File',
            /* 'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time', */
        ];
    }

    /**
     * @inheritdoc
     * @return DetailQuery the active query used by this AR class.
     */
    /* public static function find()
    {
        return new DetailQuery(get_called_class());
    } */
}
