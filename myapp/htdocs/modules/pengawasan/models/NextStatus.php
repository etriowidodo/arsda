<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.next_status".
 *
 * @property integer $id_next_status
 * @property integer $status_awal
 * @property integer $status_akhir
 * @property string $keterangan
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class NextStatus extends \yii\db\ActiveRecord
{
    public $id_akhir;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.next_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_awal', 'status_akhir', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['keterangan'], 'string', 'max' => 150],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_next_status' => 'Id Next Status',
            'status_awal' => 'Status Awal',
            'status_akhir' => 'Status Akhir',
            'keterangan' => 'Keterangan',
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
