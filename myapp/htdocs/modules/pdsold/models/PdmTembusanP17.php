<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tembusan_p17".
 *
 * @property string $id_tembusan
 * @property integer $no_urut
 * @property string $id_p17
 * @property string $tembusan
 *
 * @property PdmP17 $idP17
 */
class PdmTembusanP17 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan_p17';
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
            [['id_p17'], 'string', 'max' => 107],
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
            'id_p17' => 'Id P17',
            'tembusan' => 'Tembusan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdP17()
    {
        return $this->hasOne(PdmP17::className(), ['id_p17' => 'id_p17']);
    }
}
