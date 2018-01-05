<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.sp_r_sasaran".
 *
 * @property integer $sasaran_id
 * @property string $sasaran
 * @property integer $is_deleted
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class SpRSasaran extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.sp_r_sasaran';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sasaran_id', 'is_deleted', 'createdby', 'updatedby'], 'integer'],
            [['createdtime', 'updatedtime'], 'safe'],
            [['sasaran'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sasaran_id' => 'Sasaran ID',
            'sasaran' => 'Sasaran',
            'is_deleted' => 'Is Deleted',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
