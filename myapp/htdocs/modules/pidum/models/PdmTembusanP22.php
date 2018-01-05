<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tembusan_p22".
 *
 * @property string $id_tembusan
 * @property integer $no_urut
 * @property string $id_p22
 * @property string $tembusan
 *
 * @property PdmP22 $idP22
 */
class PdmTembusanP22 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan_p22';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tembusan', 'no_urut'], 'required'],
            [['no_urut'], 'integer'],
            [['id_tembusan'], 'string', 'max' => 126],
            [['id_p22'], 'string', 'max' => 121],
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
            'id_p22' => 'Id P22',
            'tembusan' => 'Tembusan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdP22()
    {
        return $this->hasOne(PdmP22::className(), ['id_p22' => 'id_p22']);
    }
}
