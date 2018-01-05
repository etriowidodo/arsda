<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kepegawaian.kp_unit_kerja".
 *
 * @property string $unitkerja_kd
 * @property string $unitkerja_nama
 * @property string $unitkerja_akronim
 * @property string $jabatan_kepala
 * @property string $unit_level
 * @property string $eselon
 * @property string $bidang
 * @property string $is_active
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class KpUnitKerja extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kepegawaian.kp_unit_kerja';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['createdby', 'updatedby'], 'integer'],
            [['createdtime', 'updatedtime'], 'safe'],
            [['unitkerja_kd'], 'string', 'max' => 12],
            [['unitkerja_nama'], 'string', 'max' => 90],
            [['unitkerja_akronim'], 'string', 'max' => 45],
            [['jabatan_kepala', 'unit_level'], 'string', 'max' => 50],
            [['eselon'], 'string', 'max' => 5],
            [['bidang'], 'string', 'max' => 80],
            [['is_active'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'unitkerja_kd' => 'Unitkerja Kd',
            'unitkerja_nama' => 'Unitkerja Nama',
            'unitkerja_akronim' => 'Unitkerja Akronim',
            'jabatan_kepala' => 'Jabatan Kepala',
            'unit_level' => 'Unit Level',
            'eselon' => 'Eselon',
            'bidang' => 'Bidang',
            'is_active' => 'Is Active',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
