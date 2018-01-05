<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kepegawaian.kp_r_golpangkat".
 *
 * @property string $gol_atas
 * @property string $gol_kd
 * @property string $gol_grup
 * @property string $gol_pangkat
 * @property string $gol_pangkatjaksa
 * @property string $gol_bawah
 * @property integer $is_deleted
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class KpRGolpangkat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kepegawaian.kp_r_golpangkat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_deleted', 'createdby', 'updatedby'], 'integer'],
            [['createdtime', 'updatedtime'], 'safe'],
            [['gol_atas', 'gol_kd', 'gol_bawah'], 'string', 'max' => 5],
            [['gol_grup'], 'string', 'max' => 3],
            [['gol_pangkat', 'gol_pangkatjaksa'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gol_atas' => 'Gol Atas',
            'gol_kd' => 'Gol Kd',
            'gol_grup' => 'Gol Grup',
            'gol_pangkat' => 'Gol Pangkat',
            'gol_pangkatjaksa' => 'Gol Pangkatjaksa',
            'gol_bawah' => 'Gol Bawah',
            'is_deleted' => 'Is Deleted',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
