<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_15_saran".
 *
 * @property string $id_was_15_saran
 * @property string $id_was_15
 * @property integer $id_terlapor
 * @property integer $id_peraturan
 * @property string $tingkat_kd
 * @property string $upload_file
 * @property integer $is_deleted
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property integer $rncn_jatuh_hukdis_was_15
 */
class Was15Saran extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.was_15_saran';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_terlapor', 'id_peraturan', 'created_by', 'updated_by', 'rncn_jatuh_hukdis_was_15'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_was_15'], 'string', 'max' => 16],
            [['tingkat_kd'], 'string', 'max' => 4],
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
            'id_was_15_saran' => 'Id Was 15 Saran',
            'id_was_15' => 'Id Was 15',
            'id_terlapor' => 'Id Terlapor',
            'id_peraturan' => 'Id Peraturan',
            'tingkat_kd' => 'Tingkat Kd',
            'upload_file' => 'Upload File',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'rncn_jatuh_hukdis_was_15' => 'Rncn Jatuh Hukdis Was 15',
        ];
    }
}
