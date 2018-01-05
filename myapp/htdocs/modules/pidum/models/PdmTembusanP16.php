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
class PdmTembusanP16 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan_p16';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tembusan', 'no_urut'], 'required'],
            [['no_urut'], 'integer'],
            [['id_tembusan'], 'string', 'max' => 112],
            [['id_p16'], 'string', 'max' => 107],
            [['tembusan'], 'string', 'max' => 255]
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
            'id_p16' => 'Id P16',
            'tembusan' => 'Tembusan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdP16()
    {
        return $this->hasOne(PdmP16::className(), ['id_p16' => 'id_p16']);
    }
}
