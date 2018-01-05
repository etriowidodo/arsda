<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_detail_t9".
 *
 * @property string $no_surat_t9
 * @property string $id_tersangka
 * @property string $lokasi_tahanan
 * @property string $lokasi_pindah
 * @property string $flag
 * @property string $no_register_perkara
 * @property string $no_reg_tahanan_jaksa
 */
class PdmDetailT9 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_detail_t9';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_surat_t9', 'no_register_perkara', 'no_reg_tahanan_jaksa'], 'required'],
            [['no_surat_t9', 'id_tersangka'], 'string', 'max' => 16],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['lokasi_tahanan', 'no_reg_tahanan_jaksa'], 'string', 'max' => 60],
            [['lokasi_pindah'], 'string', 'max' => 128],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_surat_t9' => 'No Surat T9',
            'id_tersangka' => 'Id Tersangka',
            'lokasi_tahanan' => 'Lokasi Tahanan',
            'lokasi_pindah' => 'Lokasi Pindah',
            'flag' => 'Flag',
            'no_register_perkara' => 'No Register Perkara',
            'no_reg_tahanan_jaksa' => 'No Reg Tahanan Jaksa',
        ];
    }
}
