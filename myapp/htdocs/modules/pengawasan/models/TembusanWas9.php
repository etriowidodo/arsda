<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.tembusan_was_9".
 *
 * @property string $id_tembusan_was_9
 * @property string $id_was_9
 * @property integer $id_pejabat_tembusan
 * @property integer $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class TembusanWas9 extends WasRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.tembusan_was_9';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pejabat_tembusan', 'flag', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_was_9'], 'string', 'max' => 16],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tembusan_was_9' => 'Id Tembusan Was 9',
            'id_was_9' => 'Id Was 9',
            'id_pejabat_tembusan' => 'Id Pejabat Tembusan',
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