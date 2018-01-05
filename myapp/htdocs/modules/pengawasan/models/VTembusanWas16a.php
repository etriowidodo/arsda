<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_tembusan_was_16a".
 *
 * @property string $id_was_16a
 * @property string $jabatan
 */
class VTembusanWas16a extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_tembusan_was_16a';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_was_16a'], 'string', 'max' => 16],
            [['jabatan'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_16a' => 'Id Was 16a',
            'jabatan' => 'Jabatan',
        ];
    }
}
