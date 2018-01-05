<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_config".
 *
 * @property string $kd_satker
 * @property string $time_format
 * @property string $flag
 */
class PdmConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kd_satker'], 'required'],
            [['kd_satker'], 'string', 'max' => 50],
            [['time_format'], 'string', 'max' => 3],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kd_satker' => 'Kd Satker',
            'time_format' => 'Time Format',
            'flag' => 'Flag',
        ];
    }
}
