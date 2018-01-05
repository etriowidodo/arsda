<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.sumber_pengaduan".
 *
 * @property integer $id_sumber_pengaduan
 * @property string $nm_sumber_pengaduan
 * @property string $keterangan
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class SumberPengaduan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.sumber_pengaduan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sumber_pengaduan'], 'required'],
            [['id_sumber_pengaduan', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['nm_sumber_pengaduan'], 'string', 'max' => 60],
            [['keterangan'], 'string', 'max' => 200],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_sumber_pengaduan' => 'Id Sumber Pengaduan',
            'nm_sumber_pengaduan' => 'Nm Sumber Pengaduan',
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
