<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p41_barbuk".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_p41
 * @property string $no_reg_bukti
 * @property integer $no_urut_bb
 * @property integer $id_ms_barbuk_eksekusi
 */
class PdmP41Barbuk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p41_barbuk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p41', 'no_reg_bukti'], 'required'],
            [['no_urut_bb', 'id_ms_barbuk_eksekusi'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_p41'], 'string', 'max' => 50],
            [['no_reg_bukti'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_surat_p41' => 'No Surat P41',
            'no_reg_bukti' => 'No Reg Bukti',
            'no_urut_bb' => 'No Urut Bb',
            'id_ms_barbuk_eksekusi' => 'Id Ms Barbuk Eksekusi',
        ];
    }
}
