<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.vw_gridtahap2".
 *
 * @property string $no_register_perkara
 * @property string $tersangka
 * @property string $asal
 * @property string $tgl_surat
 * @property string $no_surat
 * @property string $no_p16a
 * @property string $nama_jaksa
 * @property string $undang
 * @property string $pasal
 * @property string $status
 */
class PdmGridTahap2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_gridtahap2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tersangka', 'no_p16a', 'nama_jaksa', 'undang', 'pasal', 'status'], 'string'],
            [['tgl_surat'], 'safe'],
            [['no_register_perkara'], 'string', 'max' => 60],
            [['asal'], 'string', 'max' => 100],
            [['no_surat'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'tersangka' => 'Tersangka',
            'asal' => 'Asal',
            'tgl_surat' => 'Tgl Surat',
            'no_surat' => 'No Surat',
            'no_p16a' => 'No P16a',
            'nama_jaksa' => 'Nama Jaksa',
            'undang' => 'Undang',
            'pasal' => 'Pasal',
            'status' => 'Status',
        ];
    }
}
