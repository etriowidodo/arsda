<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_saksi_internal".
 *
 * @property string $peg_nip
 * @property string $peg_nama
 * @property string $jabatan
 * @property string $id_register
 * @property string $id_saksi_internal
 * @property string $peg_nrp
 * @property string $jabat_unitkerja
 */
class VSaksiInternal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_saksi_internal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jabatan', 'gol_pangkat'], 'string'],
            [['peg_nip'], 'string', 'max' => 20],
            [['peg_nama'], 'string', 'max' => 65],
            [['id_register', 'id_saksi_internal'], 'string', 'max' => 16],
            [['peg_nrp', 'jabat_unitkerja'], 'string', 'max' => 12]
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
            'id_saksi_internal' => 'Id Saksi Internal',
            'peg_nrp' => 'Peg Nrp',
            'jabat_unitkerja' => 'Jabat Unitkerja',
        ];
    }
}
