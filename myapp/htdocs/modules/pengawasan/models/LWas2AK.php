<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.l_was_2_a_k".
 *
 * @property string $id_l_was_2_a_k
 * @property string $id_l_was_2
 * @property integer $analisa_kesimpulan
 * @property string $isi
 * @property string $upload_file
 * @property integer $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class LWas2AK extends WasRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.l_was_2_a_k';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['analisa_kesimpulan', 'flag', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_l_was_2'], 'string', 'max' => 16],
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
            'id_l_was_2_a_k' => 'Id L Was 2 A K',
            'id_l_was_2' => 'Id L Was 2',
            'analisa_kesimpulan' => 'Analisa Kesimpulan',
            'isi' => 'Isi',
            'upload_file' => 'Upload File',
            'flag' => 'Is Deleted',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
