<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tembusan_t4".
 *
 * @property string $id_tembusan
 * @property integer $no_urut
 * @property string $id_t4
 * @property string $tembusan
 *
 * @property PdmT4 $idT4
 */
class PdmTembusanT7 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan_t7';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara'], 'required'],
            [['no_urut'], 'integer'],
            [['no_surat_t7'], 'string', 'max' => 177],
            [['no_register_perkara'], 'string', 'max' => 172],
            [['tembusan'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_surat_t7' => 'No Surat T7',
            'no_urut' => 'No Urut',
            'no_register_perkara' => 'NO Register Perkara',
            'tembusan' => 'Tembusan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getIdT4()
    // {
    //     return $this->hasOne(Pdm74::className(), ['no_surat_t7' => 'no_surat_t7']);
    // }
}
