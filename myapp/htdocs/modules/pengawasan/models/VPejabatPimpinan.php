<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_pejabat_pimpinan".
 *
 * @property integer $id_jabatan_pejabat
 * @property string $wilayah
 * @property string $jabatan
 * @property string $bidang
 */
class VPejabatPimpinan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_pejabat_pimpinan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_jabatan_pejabat'], 'integer'],
            [['wilayah'], 'string'],
            [['jabatan'], 'string', 'max' => 200],
            [['bidang'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_jabatan_pejabat' => 'Id Jabatan Pejabat',
            'wilayah' => 'Wilayah',
            'jabatan' => 'Jabatan',
            'bidang' => 'Bidang',
        ];
    }
}
