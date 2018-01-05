<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tembusan_p43".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_p43
 * @property integer $no_urut
 * @property string $tembusan
 */
class PdmTembusanP43 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan_p43';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p43', 'no_urut'], 'required'],
            [['no_urut'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_p43'], 'string', 'max' => 50],
            [['tembusan'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_surat_p43' => 'No Surat P43',
            'no_urut' => 'No Urut',
            'tembusan' => 'Tembusan',
        ];
    }
}