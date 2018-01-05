<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kepegawaian.kp_r_kddknhkm".
 *
 * @property integer $pns_kddkn_hkm
 * @property string $deskripsi
 * @property integer $is_deleted
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class KpRKddknhkm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kepegawaian.kp_r_kddknhkm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pns_kddkn_hkm', 'is_deleted', 'createdby', 'updatedby'], 'integer'],
            [['createdtime', 'updatedtime'], 'safe'],
            [['deskripsi'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pns_kddkn_hkm' => 'Pns Kddkn Hkm',
            'deskripsi' => 'Deskripsi',
            'is_deleted' => 'Is Deleted',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
