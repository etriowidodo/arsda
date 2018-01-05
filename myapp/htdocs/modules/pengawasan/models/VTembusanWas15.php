<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_tembusan_was_15".
 *
 * @property string $id_was_15
 * @property string $jabatan
 */
class VTembusanWas15 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_tembusan_was_15';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_was_15'], 'string', 'max' => 16],
            [['jabatan'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_15' => 'Id Was 15',
            'jabatan' => 'Jabatan',
        ];
    }
}
