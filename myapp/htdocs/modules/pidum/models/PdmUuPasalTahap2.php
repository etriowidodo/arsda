<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_uu_pasal_tahap2".
 *
 * @property string $no_register_perkara
 * @property string $undang
 * @property string $pasal
 * @property string $dakwaan
 * @property string $id_pasal
 * @property integer $pembuktian
 * @property string $no_surat_p41
 * @property integer $status_rentut
 * @property string $no_reg_tahanan
 * @property string $proses
 * @property string $tentang
 */
class PdmUuPasalTahap2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_uu_pasal_tahap2';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'id_pasal'], 'required'],
            [['pembuktian', 'status_rentut'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 135],
            [['undang', 'id_pasal'], 'string', 'max' => 50],
            [['pasal', 'dakwaan'], 'string', 'max' => 128],
            [['no_surat_p41'], 'string', 'max' => 60],
            [['no_reg_tahanan'], 'string', 'max' => 16],
            [['proses', 'tentang'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'undang' => 'Undang',
            'pasal' => 'Pasal',
            'dakwaan' => 'Dakwaan',
            'id_pasal' => 'Id Pasal',
            'pembuktian' => 'Pembuktian',
            'no_surat_p41' => 'No Surat P41',
            'status_rentut' => 'Status Rentut',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'proses' => 'Proses',
            'tentang' => 'Tentang',
        ];
    }
}
