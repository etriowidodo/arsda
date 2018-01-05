<?php

namespace app\modules\pidum\models;

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
class PdmTembusanT4 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan_t4';
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
            [['id_t4'], 'string', 'max' => 172],
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
            'id_t4' => 'Id T4',
            'tembusan' => 'Tembusan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdT4()
    {
        return $this->hasOne(PdmT4::className(), ['id_t4' => 'id_t4']);
    }
}
