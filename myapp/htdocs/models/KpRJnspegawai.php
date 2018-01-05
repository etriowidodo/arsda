<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kepegawaian.kp_r_jnspegawai".
 *
 * @property integer $peg_jnspeg
 * @property string $deskripsi
 * @property integer $is_deleted
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class KpRJnspegawai extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kepegawaian.kp_r_jnspegawai';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['peg_jnspeg', 'is_deleted', 'createdby', 'updatedby'], 'integer'],
            [['createdtime', 'updatedtime'], 'safe'],
            [['deskripsi'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'peg_jnspeg' => 'Peg Jnspeg',
            'deskripsi' => 'Deskripsi',
            'is_deleted' => 'Is Deleted',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
