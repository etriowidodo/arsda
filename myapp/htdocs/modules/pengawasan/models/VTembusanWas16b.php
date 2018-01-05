<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_tembusan_was_16b".
 *
 * @property string $id_was_16b
 * @property string $jabatan
 */
class VTembusanWas16b extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_tembusan_was_16b';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_was_16b'], 'string', 'max' => 16],
            [['jabatan'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_16b' => 'Id Was 16b',
            'jabatan' => 'Jabatan',
        ];
    }
}
