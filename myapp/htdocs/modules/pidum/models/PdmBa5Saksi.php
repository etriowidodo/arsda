<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba5_saksi".
 *
 * @property string $no_register_perkara
 * @property string $nip
 * @property string $nama
 * @property string $jabatan
 * @property string $pangkat
 * @property integer $no_urut
 * @property string $peg_nip_baru
 */
class PdmBa5Saksi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba5_saksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'nama', 'jabatan', 'pangkat', 'no_urut'], 'required'],
            [['no_urut'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['nip', 'peg_nip_baru'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 128],
            [['jabatan'], 'string', 'max' => 2000],
            [['pangkat'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'nip' => 'Nip',
            'nama' => 'Nama',
            'jabatan' => 'Jabatan',
            'pangkat' => 'Pangkat',
            'no_urut' => 'No Urut',
            'peg_nip_baru' => 'Peg Nip Baru',
        ];
    }
}
