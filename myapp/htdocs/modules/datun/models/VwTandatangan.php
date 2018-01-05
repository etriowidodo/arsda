<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.vw_tandatangan".
 *
 * @property string $peg_nik
 * @property string $peg_nip_baru
 * @property string $nama
 * @property string $jabatan
 * @property string $pangkat
 */
class VwTandatangan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_tandatangan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['peg_nik', 'peg_nip_baru'], 'string', 'max' => 20],
            [['nama', 'jabatan'], 'string', 'max' => 128],
            [['pangkat'], 'string', 'max' => 64]
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
            'jabatan' => 'Jabatan',
            'pangkat' => 'Pangkat',
        ];
    }
}
