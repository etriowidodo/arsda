<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kepegawaian.kp_eselon".
 *
 * @property string $gol_kd
 * @property string $eselon
 * @property string $eselon_grup
 * @property integer $is_deleted
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class KpEselon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kepegawaian.kp_eselon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gol_kd'], 'required'],
            [['is_deleted', 'createdby', 'updatedby'], 'integer'],
            [['createdtime', 'updatedtime'], 'safe'],
            [['gol_kd'], 'string', 'max' => 5],
            [['eselon'], 'string', 'max' => 6],
            [['eselon_grup'], 'string', 'max' => 4]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gol_kd' => 'Gol Kd',
            'eselon' => 'Eselon',
            'eselon_grup' => 'Eselon Grup',
            'is_deleted' => 'Is Deleted',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
