<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tembusan_p26".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_p26
 * @property integer $no_urut
 * @property string $tembusan
 *
 * @property PdmP26 $noRegisterPerkara
 */
class PdmTembusanP26 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan_p26';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p26', 'no_urut'], 'required'],
            [['no_urut'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_p26'], 'string', 'max' => 50],
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
            'no_surat_p26' => 'No Surat P26',
            'no_urut' => 'No Urut',
            'tembusan' => 'Tembusan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoRegisterPerkara()
    {
        return $this->hasOne(PdmP26::className(), ['no_register_perkara' => 'no_register_perkara', 'no_surat_p26' => 'no_surat_p26']);
    }
}