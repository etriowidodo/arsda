<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.max_year".
 *
 * @property integer $no_reg
 */
class MaxYear extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.max_year';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_reg'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_reg' => 'No Reg',
        ];
    }
}
