<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.ba_was_4".
 *
 * @property string $id_ba_was_4
 * @property string $id_register
 * @property integer $id_saksi_eksternal
 * @property string $tempat
 * @property string $tgl
 * @property string $upload_file
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class BaWas4 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.ba_was_4';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba_was_4'], 'required'],
            [['id_saksi_eksternal', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['tgl', 'created_time', 'updated_time'], 'safe'],
            [['id_ba_was_4', 'id_register'], 'string', 'max' => 20],
            [['tempat'], 'string', 'max' => 60],
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
            'id_ba_was_4' => 'Id Ba Was 4',
            'id_register' => 'Id Register',
            'id_saksi_eksternal' => 'Id Saksi Eksternal',
            'tempat' => 'Tempat',
            'tgl' => 'Tgl',
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
