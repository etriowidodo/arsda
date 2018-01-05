<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_tembusan_was_16c".
 *
 * @property string $id_was_16c
 * @property string $jabatan
 */
class VTembusanWas16c extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_tembusan_was_16c';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_was_16c'], 'string', 'max' => 16],
            [['jabatan'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_16c' => 'Id Was 16c',
            'jabatan' => 'Jabatan',
        ];
    }
}
