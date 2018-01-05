<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_jaksa_p16a".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_p16a
 * @property integer $no_urut
 * @property string $nip
 * @property string $nama
 * @property string $jabatan
 * @property string $pangkat
 * @property string $keterangan
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 */
class PdmJaksaP16a extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_jaksa_p16a';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p16a', 'no_urut'], 'required'],
            [['no_urut'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_p16a'], 'string', 'max' => 50],
            [['nip'], 'string', 'max' => 20],
            [['nama', 'keterangan'], 'string', 'max' => 128],
            [['jabatan'], 'string', 'max' => 2000],
            [['pangkat'], 'string', 'max' => 256],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_surat_p16a' => 'No Surat P16a',
            'no_urut' => 'No Urut',
            'nip' => 'Nip',
            'nama' => 'Nama',
            'jabatan' => 'Jabatan',
            'pangkat' => 'Pangkat',
            'keterangan' => 'Keterangan',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
        ];
    }
}
