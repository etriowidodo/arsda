<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.ba_was_2_detail".
 *
 * @property integer $id_ba_was_2_detail
 * @property integer $id_ba_was_2
 * @property string $hasil
 * @property string $upload_file
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class BaWas2Detail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.ba_was_2_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba_was_2', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['hasil'], 'string', 'max' => 2000],
            [['upload_file'], 'string', 'max' => 200],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ba_was_2_detail' => 'Id Ba Was 2 Detail',
            'id_ba_was_2' => 'Id Ba Was 2',
            'hasil' => 'Hasil',
            'upload_file' => 'Upload File',
            'is_deleted' => 'Is Deleted',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
