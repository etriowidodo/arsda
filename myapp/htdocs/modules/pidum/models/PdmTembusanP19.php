<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tembusan_p19".
 *
 * @property string $id_tembusan
 * @property integer $no_urut
 * @property string $id_p19
 * @property string $tembusan
 *
 * @property PdmP19 $idP19
 */
class PdmTembusanP19 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan_p19';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tembusan', 'no_urut'], 'required'],
            [['no_urut'], 'integer'],
            [['id_tembusan'], 'string', 'max' => 177],
            [['id_p19'], 'string', 'max' => 172],
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
            'id_p19' => 'Id P19',
            'tembusan' => 'Tembusan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdP19()
    {
        return $this->hasOne(PdmP19::className(), ['id_p19' => 'id_p19']);
    }
}
