<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tembusan_p16".
 *
 * @property string $id_tembusan
 * @property integer $no_urut
 * @property string $id_p16
 * @property string $tembusan
 *
 * @property PdmP16 $idP16
 */
class PdmTembusanP16a extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan_p16a';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara','no_surat_p16a', 'no_urut'], 'required'],
            [['no_urut'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_p16a'], 'string', 'max' => 50],
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
            'no_surat_p16a' => 'No Surat P16A',
            'no_urut' => 'No Urut',
            'tembusan' => 'Tembusan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdP16a()
    {
        return $this->hasOne(PdmP16a::className(), ['no_surat_p16a' => 'no_surat_p16a']);
    }
}
