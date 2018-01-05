<?php

namespace app\modules\pengawasan\models;
use Yii;

/**
 * This is the model class for table "was.tembusan_was_20b".
 *
 * @property string $id_tembusan_was_20b
 * @property string $id_was_20b
 * @property integer $id_pejabat_tembusan
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class TembusanWas20b extends WasRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.tembusan_was_20b';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pejabat_tembusan'], 'integer'],
         //   [['created_time', 'updated_time'], 'safe'],
            [['id_was_20b'], 'string', 'max' => 16],
           [['flag'], 'string', 'max' => 1],
           [['created_ip', 'updated_ip'], 'string', 'max' => 18]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tembusan_was_20b' => 'Id Tembusan Was 20b',
            'id_was_20b' => 'Id Was 20b',
            'id_pejabat_tembusan' => 'Id Pejabat Tembusan',
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
