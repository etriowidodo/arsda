<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.ba_was_2".
 *
 * @property integer $id_ba_was_2
 * @property string $inst_satkerkd
 * @property string $id_register
 * @property string $hari
 * @property string $tgl
 * @property string $tempat
 * @property integer $tunggal_jamak
 * @property integer $sebagai
 * @property integer $id_peran
 * @property integer $id_pemeriksa
 * @property string $upload_file
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class BaWas2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.ba_was_2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl', 'created_time', 'updated_time'], 'safe'],
            [['tunggal_jamak', 'sebagai', 'id_peran', 'id_pemeriksa', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['inst_satkerkd', 'hari'], 'string', 'max' => 10],
            [['id_register'], 'string', 'max' => 20],
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
            'id_ba_was_2' => 'Id Ba Was 2',
            'inst_satkerkd' => 'Inst Satkerkd',
            'id_register' => 'Id Register',
            'hari' => 'Hari',
            'tgl' => 'Tgl',
            'tempat' => 'Tempat',
            'tunggal_jamak' => 'Tunggal Jamak',
            'sebagai' => 'Sebagai',
            'id_peran' => 'Id Peran',
            'id_pemeriksa' => 'Id Pemeriksa',
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
