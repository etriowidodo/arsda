<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba5_jaksa".
 *
 * @property string $no_register_perkara
 * @property string $tgl_ba5
 * @property integer $no_urut
 * @property string $nip
 * @property string $nama
 * @property string $jabatan
 * @property string $pangkat
 * @property string $peg_nip_baru
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 */
class PdmJaksaBa5 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba5_jaksa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'tgl_ba5', 'no_urut'], 'required'],
            [['tgl_ba5'], 'safe'],
            [['no_urut'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['nip', 'peg_nip_baru'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 128],
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
            'tgl_ba5' => 'Tgl Ba5',
            'no_urut' => 'No Urut',
            'nip' => 'Nip',
            'nama' => 'Nama',
            'jabatan' => 'Jabatan',
            'pangkat' => 'Pangkat',
            'peg_nip_baru' => 'Peg Nip Baru',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
        ];
    }
}
