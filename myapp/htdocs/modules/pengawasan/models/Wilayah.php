<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.wilayah".
 *
 * @property integer $id_wilayah
 * @property string $nm_wilayah
 * @property string $keterangan
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class Wilayah extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.wilayah';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_wilayah'], 'required'],
            [['id_wilayah', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['nama_wilayah'], 'string', 'max' => 5],
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
            'id_wilayah' => 'Id Wilayah',
            'nama_wilayah' => 'Nama Wilayah',
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
