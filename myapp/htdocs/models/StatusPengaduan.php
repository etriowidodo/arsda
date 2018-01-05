<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.status_pengaduan".
 *
 * @property string $id_status_pengaduan
 * @property string $nama_status
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class StatusPengaduan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.status_pengaduan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_status_pengaduan'], 'required'],
            [['is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_status_pengaduan'], 'string', 'max' => 20],
            [['nama_status'], 'string', 'max' => 100],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_status_pengaduan' => 'Id Status Pengaduan',
            'nama_status' => 'Nama Status',
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
