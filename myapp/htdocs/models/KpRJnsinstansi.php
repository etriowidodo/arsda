<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kepegawaian.kp_r_jnsinstansi".
 *
 * @property integer $jenis_instansi
 * @property string $deskripsi
 * @property string $akronim
 * @property integer $is_deleted
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class KpRJnsinstansi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kepegawaian.kp_r_jnsinstansi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jenis_instansi', 'is_deleted', 'createdby', 'updatedby'], 'integer'],
            [['createdtime', 'updatedtime'], 'safe'],
            [['deskripsi', 'akronim'], 'string', 'max' => 35]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'jenis_instansi' => 'Jenis Instansi',
            'deskripsi' => 'Deskripsi',
            'akronim' => 'Akronim',
            'is_deleted' => 'Is Deleted',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
