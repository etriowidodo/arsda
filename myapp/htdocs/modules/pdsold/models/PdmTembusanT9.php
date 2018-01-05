<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tembusan_t9".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_t9
 * @property integer $no_urut
 * @property string $tembusan
 */
class PdmTembusanT9 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan_t9';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_t9', 'no_urut'], 'required'],
            [['no_urut'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_t9'], 'string', 'max' => 50],
            [['tembusan'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_surat_t9' => 'No Surat T9',
            'no_urut' => 'No Urut',
            'tembusan' => 'Tembusan',
        ];
    }
}