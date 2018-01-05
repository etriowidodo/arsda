<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.vw_datap13".
 *
 * @property string $id_perkara
 * @property string $id_p13
 * @property string $nama
 * @property string $no_surat
 * @property string $ket_saksi
 */
class VwDatap13 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_datap13';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'ket_saksi'], 'string'],
            [['id_perkara', 'id_p13'], 'string', 'max' => 16],
            [['no_surat'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perkara' => 'Id Perkara',
            'id_p13' => 'Id P13',
            'nama' => 'Nama',
            'no_surat' => 'No Surat',
            'ket_saksi' => 'Ket Saksi',
        ];
    }
}
