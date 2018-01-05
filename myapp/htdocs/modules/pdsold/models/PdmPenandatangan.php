<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_penandatangan".
 *
 * @property string $peg_nik
 * @property string $nama
 * @property string $pangkat
 * @property string $jabatan
 * @property string $keterangan
 * @property string $is_active
 * @property string $flag
 */
class PdmPenandatangan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_penandatangan';
    }

    /**
     * @inheritdoc
     */
	 //bowo 30 mei 2016 #menambahkan field peg_nip_baru
    public function rules()
    {
        return [
            [['peg_nik', 'nama', 'pangkat', 'jabatan', 'keterangan', 'peg_nip_baru'], 'required'],
            [['peg_nik','peg_nip_baru'], 'string', 'max' => 20],
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
			'peg_nip_baru' => 'NIP',
        ];
    }
}
