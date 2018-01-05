<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tembusan_t10".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_t10
 * @property integer $no_urut
 * @property string $tembusan
 *
 * @property PdmT10 $noRegisterPerkara
 */
class PdmTembusanT10 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan_t10';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_t10', 'no_urut'], 'required'],
            [['no_urut'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_t10'], 'string', 'max' => 50],
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
            'no_surat_t10' => 'No Surat T10',
            'no_urut' => 'No Urut',
            'tembusan' => 'Tembusan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoRegisterPerkara()
    {
        return $this->hasOne(PdmT10::className(), ['no_register_perkara' => 'no_register_perkara', 'no_surat_t10' => 'no_surat_t10']);
    }
}
