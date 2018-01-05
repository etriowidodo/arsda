<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tembusan_narkotika".
 *
 * @property string $id_tembusan
 * @property integer $no_urut
 * @property string $id_sita
 * @property string $tembusan
 *
 * @property PdmPenetapanBarbuk $idSita
 */
class PdmTembusanNarkotika extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan_narkotika';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tembusan', 'no_urut'], 'required'],
            [['no_urut'], 'integer'],
            [['id_tembusan'], 'string', 'max' => 61],
            [['id_sita'], 'string', 'max' => 56],
            [['tembusan'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tembusan' => 'Id Tembusan',
            'no_urut' => 'No Urut',
            'id_sita' => 'Id Sita',
            'tembusan' => 'Tembusan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSita()
    {
        return $this->hasOne(PdmPenetapanBarbuk::className(), ['id_sita' => 'id_sita']);
    }
}
