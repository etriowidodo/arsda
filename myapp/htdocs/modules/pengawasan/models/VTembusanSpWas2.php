<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_tembusan_sp_was_2".
 *
 * @property string $id_sp_was_2
 * @property string $jabatan
 */
class VTembusanSpWas2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_tembusan_sp_was_2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sp_was_2'], 'string', 'max' => 16],
            [['jabatan'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_sp_was_2' => 'Id Sp Was 2',
            'jabatan' => 'Jabatan',
        ];
    }
}
