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
class BaWas4Detail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.ba_was_4_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id_ba_was_4_detail'], 'required'],
            //[['created_by', 'updated_by'], 'integer'],
            //[['updated_time'], 'safe'],
            [['id_ba_was_4_detail', 'id_ba_was_4'], 'string', 'max' => 16],
            [['pernyataan'], 'string', 'max' => 2000],
            //[['upload_file'], 'string', 'max' => 200]
            //[['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ba_was_4_detail' => 'Id Ba Was 4 Detail',
            'id_ba_was_4' => 'Id Ba Was 4',
            'pernyataan' => 'Pernyataan',
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
