<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_tembusan_was_16d".
 *
 * @property string $id_was_16d
 * @property string $jabatan
 */
class VTembusanWas16d extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_tembusan_was_16d';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_was_16d'], 'string', 'max' => 16],
            [['jabatan'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_16d' => 'Id Was 16d',
            'jabatan' => 'Jabatan',
        ];
    }
}
