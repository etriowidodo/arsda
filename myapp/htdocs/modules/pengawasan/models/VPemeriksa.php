<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_pemeriksa".
 *
 * @property string $peg_nip
 * @property string $peg_nama
 * @property string $jabatan
 * @property string $id_register
 * @property string $id_pemeriksa
 * @property string $peg_nrp
 * @property integer $sp_was_1
 * @property integer $sp_was_2
 */
class VPemeriksa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_pemeriksa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jabatan', 'gol_pangkat'], 'string'],
            [['sp_was_1', 'sp_was_2'], 'integer'],
            [['peg_nip'], 'string', 'max' => 20],
            [['peg_nama'], 'string', 'max' => 65],
            [['id_register', 'id_pemeriksa'], 'string', 'max' => 16],
            [['peg_nrp'], 'string', 'max' => 12]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'peg_nip' => 'Peg Nip',
            'peg_nama' => 'Peg Nama',
            'jabatan' => 'Jabatan',
            'id_register' => 'Id Register',
            'id_pemeriksa' => 'Id Pemeriksa',
            'peg_nrp' => 'Peg Nrp',
            'sp_was_1' => 'Sp Was 1',
            'sp_was_2' => 'Sp Was 2',
        ];
    }
}
