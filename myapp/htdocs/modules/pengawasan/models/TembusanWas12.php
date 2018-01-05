<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.tembusan_was_12".
 *
 * @property string $id_tembusan_was_12
 * @property string $id_was_12
 * @property integer $id_pejabat_tembusan
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class TembusanWas12 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.tembusan_was_12';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pejabat_tembusan', 'created_by', 'updated_by'], 'integer'],
            [['created_time', 'updated_time'], 'safe'],
            [['id_was_12'], 'string', 'max' => 16],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tembusan_was_12' => 'Id Tembusan Was 12',
            'id_was_12' => 'Id Was 12',
            'id_pejabat_tembusan' => 'Id Pejabat Tembusan',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
