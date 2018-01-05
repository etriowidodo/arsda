<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tembusan_t5".
 *
 * @property string $id_tembusan
 * @property integer $no_urut
 * @property string $id_t5
 * @property string $tembusan
 *
 * @property PdmT5 $idT5
 */
class PdmTembusanT5 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan_t5';
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
            [['id_t5'], 'string', 'max' => 172],
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
            'id_t5' => 'Id T5',
            'tembusan' => 'Tembusan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdT5()
    {
        return $this->hasOne(PdmT5::className(), ['id_t5' => 'id_t5']);
    }
}
