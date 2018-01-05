<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_15_ptimbangan".
 *
 * @property string $id_was_15_ptimbangan
 * @property string $id_was_15
 * @property integer $ringan_berat
 * @property string $isi
 * @property string $upload_file
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class Was15Ptimbangan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_15_ptimbangan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ringan_berat',  'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_was_15'], 'string', 'max' => 16],
            [['isi'], 'string', 'max' => 1000],
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
            'id_was_15_ptimbangan' => 'Id Was 15 Ptimbangan',
            'id_was_15' => 'Id Was 15',
            'ringan_berat' => 'Ringan Berat',
            'isi' => 'Isi',
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
