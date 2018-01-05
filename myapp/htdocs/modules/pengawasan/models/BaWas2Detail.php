<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.ba_was_2_detail".
 *
 * @property string $id_ba_was_2_detail
 * @property string $id_ba_was_2
 * @property string $hasil
 * @property string $upload_file
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
            [['created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_ba_was_2'], 'string', 'max' => 16],
            [['hasil'], 'string', 'max' => 2000],
            [['upload_file'], 'string', 'max' => 200],
            [['flag'], 'string', 'max' => 1],
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
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
