<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tembusan_p21a".
 *
 * @property string $id_tembusan
 * @property integer $no_urut
 * @property string $id_p21a
 * @property string $tembusan
 *
 * @property PdmP21a $idP21a
 */
class PdmTembusanP21a extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan_p21a';
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
            [['id_p21a'], 'string', 'max' => 121],
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
            'id_p21a' => 'Id P21a',
            'tembusan' => 'Tembusan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdP21a()
    {
        return $this->hasOne(PdmP21a::className(), ['id_p21a' => 'id_p21a']);
    }
}
