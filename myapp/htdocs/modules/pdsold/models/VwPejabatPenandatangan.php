<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.vw_pejabat_penandatangan".
 *
 * @property string $peg_nik
 * @property string $peg_nip_baru
 * @property string $nama
 * @property string $pangkat
 * @property string $golongan
 * @property string $is_active
 */
class VwPejabatPenandatangan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_pejabat_penandatangan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pangkat', 'golongan'], 'string'],
            [['peg_nik', 'peg_nip_baru'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 128],
            [['is_active'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'peg_nik' => 'Peg Nik',
            'peg_nip_baru' => 'Peg Nip Baru',
            'nama' => 'Nama',
            'pangkat' => 'Pangkat',
            'golongan' => 'Golongan',
            'is_active' => 'Is Active',
        ];
    }
}
