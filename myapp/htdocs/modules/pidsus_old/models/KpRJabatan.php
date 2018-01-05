<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "kepegawaian.kp_r_jabatan".
 *
 * @property string $ref_jabatan_kd
 * @property string $ref_jabatan_desc
 * @property string $ref_jabatan_tipe
 * @property string $ref_jabatan_akronim
 * @property string $eselon
 * @property string $jenjang
 * @property string $di_level
 * @property string $unit_level
 * @property string $tunjangan
 *
 * @property KpPegawai[] $kpPegawais
 */
class KpRJabatan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kepegawaian.kp_r_jabatan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ref_jabatan_kd'], 'required'],
            [['ref_jabatan_kd', 'jenjang', 'tunjangan'], 'number'],
            [['ref_jabatan_desc'], 'string', 'max' => 35],
            [['ref_jabatan_tipe'], 'string', 'max' => 1],
            [['ref_jabatan_akronim'], 'string', 'max' => 30],
            [['eselon'], 'string', 'max' => 5],
            [['di_level'], 'string', 'max' => 15],
            [['unit_level'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ref_jabatan_kd' => 'Ref Jabatan Kd',
            'ref_jabatan_desc' => 'Ref Jabatan Desc',
            'ref_jabatan_tipe' => 'Ref Jabatan Tipe',
            'ref_jabatan_akronim' => 'Ref Jabatan Akronim',
            'eselon' => 'Eselon',
            'jenjang' => 'Jenjang',
            'di_level' => 'Di Level',
            'unit_level' => 'Unit Level',
            'tunjangan' => 'Tunjangan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKpPegawais()
    {
        return $this->hasMany(KpPegawai::className(), ['peg_jbtakhirfs' => 'ref_jabatan_kd']);
    }
}
