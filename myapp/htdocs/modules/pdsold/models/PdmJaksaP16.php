<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_jaksa_p16".
 *
 * @property string $id_jpp
 * @property string $id_perkara
 * @property string $id_p16
 * @property string $nip
 * @property string $nama
 * @property string $jabatan
 * @property string $pangkat
 * @property string $keterangan
 * @property integer $no_urut
 * @property string $peg_nip_baru
 */
class PdmJaksaP16 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_jaksa_p16';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_jpp', 'id_p16', 'no_urut'], 'required'],
            [['no_urut'], 'integer'],
            [['id_jpp'], 'string', 'max' => 112],
            [['id_perkara'], 'string', 'max' => 56],
            [['id_p16'], 'string', 'max' => 107],
            [['nip', 'peg_nip_baru'], 'string', 'max' => 20],
            [['nama', 'keterangan'], 'string', 'max' => 128],
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
            'id_jpp' => 'Id Jpp',
            'id_perkara' => 'Id Perkara',
            'id_p16' => 'Id P16',
            'nip' => 'Nip',
            'nama' => 'Nama',
            'jabatan' => 'Jabatan',
            'pangkat' => 'Pangkat',
            'keterangan' => 'Keterangan',
            'no_urut' => 'No Urut',
            'peg_nip_baru' => 'Peg Nip Baru',
        ];
    }

    /**
     * @inheritdoc
     * @return PdmJaksaP16Query the active query used by this AR class.
     */

}
