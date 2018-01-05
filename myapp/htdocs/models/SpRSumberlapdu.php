<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.sp_r_sumberlapdu".
 *
 * @property string $sumber_lapdu
 * @property string $deskripsi
 * @property integer $is_deleted
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class SpRSumberlapdu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.sp_r_sumberlapdu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_deleted', 'createdby', 'updatedby'], 'integer'],
            [['createdtime', 'updatedtime'], 'safe'],
            [['sumber_lapdu'], 'string', 'max' => 20],
            [['deskripsi'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sumber_lapdu' => 'Sumber Lapdu',
            'deskripsi' => 'Deskripsi',
            'is_deleted' => 'Is Deleted',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
