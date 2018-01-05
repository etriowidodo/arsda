<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_tembusan_sp_was_1".
 *
 * @property string $id_sp_was_1
 * @property string $jabatan
 */
class VTembusanSpWas1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_tembusan_sp_was_1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sp_was_1'], 'string', 'max' => 16],
            [['jabatan'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_sp_was_1' => 'Id Sp Was 1',
            'jabatan' => 'Jabatan',
        ];
    }
}
