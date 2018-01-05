<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_pasal_dakwaan".
 *
 * @property string $id_pasal
 * @property string $id_perkara
 * @property string $id_tersangka
 * @property string $undang
 * @property string $pasal
 * @property boolean $is_bukti
 * @property boolean $is_bukti_pn
 * @property string $flag
 *
 * @property PdmSpdp $idPerkara
 */
class PdmPasalDakwaan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_pasal_dakwaan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pasal'], 'required'],
            [['is_bukti', 'is_bukti_pn'], 'boolean'],
            [['id_pasal', 'id_perkara', 'id_tersangka'], 'string', 'max' => 16],
            [['undang', 'pasal'], 'string', 'max' => 256],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pasal' => 'Id Pasal',
            'id_perkara' => 'Id Perkara',
            'id_tersangka' => 'Id Tersangka',
            'undang' => 'Undang',
            'pasal' => 'Pasal',
            'is_bukti' => 'Is Bukti',
            'is_bukti_pn' => 'Is Bukti Pn',
            'flag' => 'Flag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPerkara()
    {
        return $this->hasOne(PdmSpdp::className(), ['id_perkara' => 'id_perkara']);
    }
}
