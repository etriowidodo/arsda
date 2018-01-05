<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_jaksa_saksi".
 *
 * @property string $id_jpp
 * @property string $id_perkara
 * @property string $code_table
 * @property string $id_table
 * @property string $nip
 * @property string $nama
 * @property string $jabatan
 * @property string $pangkat
 * @property string $keterangan
 * @property string $flag
 * @property integer $no_urut
 * @property string $peg_nip_baru
 *
 * @property PdmSpdp $idPerkara
 */
class PdmJaksaSaksi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_jaksa_saksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_jpp', 'nama', 'jabatan', 'pangkat'], 'required'],
            [['no_urut'], 'integer'],
            [['id_jpp'], 'string', 'max' => 32],
            [['id_table'], 'string', 'max' => 56],
            [['id_perkara'], 'string', 'max' => 56],
            [['code_table'], 'string', 'max' => 12],
            [['nip', 'peg_nip_baru'], 'string', 'max' => 20],
            [['nama', 'keterangan'], 'string', 'max' => 128],
            [['jabatan'], 'string', 'max' => 2000],
            [['pangkat'], 'string', 'max' => 256],
            [['flag'], 'string', 'max' => 1]
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
            'code_table' => 'Code Table',
            'id_table' => 'Id Table',
            'nip' => 'Nip',
            'nama' => 'Nama',
            'jabatan' => 'Jabatan',
            'pangkat' => 'Pangkat',
            'keterangan' => 'Keterangan',
            'flag' => 'Flag',
            'no_urut' => 'No Urut',
            'peg_nip_baru' => 'Peg Nip Baru',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPerkara()
    {
        return $this->hasOne(PdmSpdp::className(), ['id_perkara' => 'id_perkara']);
    }
}