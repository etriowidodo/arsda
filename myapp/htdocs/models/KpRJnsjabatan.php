<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kepegawaian.kp_r_jnsjabatan".
 *
 * @property integer $kode_jabatan
 * @property string $deskripsi
 * @property integer $is_deleted
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class KpRJnsjabatan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kepegawaian.kp_r_jnsjabatan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_jabatan', 'is_deleted', 'createdby', 'updatedby'], 'integer'],
            [['createdtime', 'updatedtime'], 'safe'],
            [['deskripsi'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode_jabatan' => 'Kode Jabatan',
            'deskripsi' => 'Deskripsi',
            'is_deleted' => 'Is Deleted',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
