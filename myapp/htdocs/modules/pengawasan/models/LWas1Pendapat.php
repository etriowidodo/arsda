<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.l_was_1_pendapat".
 *
 * @property string $id_l_was_1_pendapat
 * @property string $id_l_was_1
 * @property string $pendapat
 * @property string $upload_file
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class LWas1Pendapat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.l_was_1_pendapat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_l_was_1'], 'string', 'max' => 16],
            [['pendapat'], 'string', 'max' => 2000],
            [['upload_file'], 'string', 'max' => 200],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_l_was_1_pendapat' => 'Id L Was 1 Pendapat',
            'id_l_was_1' => 'Id L Was 1',
            'pendapat' => 'Pendapat',
            'upload_file' => 'Upload File',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
