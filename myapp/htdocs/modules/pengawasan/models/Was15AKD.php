<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.was_15_a_k_d".
 *
 * @property string $id_was_15_a_k_d
 * @property string $id_was_15
 * @property integer $analisa_kesimpulan
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
class Was15AKD extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'was.was_15_a_k_d';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['analisa_kesimpulan', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_was_15'], 'string', 'max' => 16],
            [['isi'], 'string', 'max' => 2000],
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
            'id_was_15_a_k_d' => 'Id Was 15 A K D',
            'id_was_15' => 'Id Was 15',
            'analisa_kesimpulan' => 'Analisa Kesimpulan',
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
