<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "testtable".
 *
 * @property integer $Id
 * @property string $data1
 * @property string $data2
 */
class Testtable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'testtable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Id'], 'required'],
            [['Id'], 'integer'],
            [['data1', 'data2'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'data1' => 'Data1',
            'data2' => 'Data2',
        ];
    }
}
