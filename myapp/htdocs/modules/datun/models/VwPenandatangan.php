<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.vw_penandatangan".
 *
 * @property string $peg_nik
 * @property string $nama
 * @property string $pangkat
 * @property string $jabatan
 * @property string $keterangan
 * @property string $is_active
 * @property string $flag
 */
class VwPenandatangan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_penandatangan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['peg_nik'], 'string', 'max' => 20],
            [['nama', 'jabatan', 'keterangan'], 'string', 'max' => 128],
            [['pangkat'], 'string', 'max' => 64],
            [['is_active', 'flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'peg_nik' => 'Peg Nik',
            'nama' => 'Nama',
            'pangkat' => 'Pangkat',
            'jabatan' => 'Jabatan',
            'keterangan' => 'Keterangan',
            'is_active' => 'Is Active',
            'flag' => 'Flag',
        ];
    }
}
