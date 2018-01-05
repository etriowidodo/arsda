<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tembusan_rendak".
 *
 * @property string $id_tembusan
 * @property integer $no_urut
 * @property string $id_rendak
 * @property string $tembusan
 *
 * @property PdmRendak $idRendak
 */
class PdmTembusanRendak extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan_rendak';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tembusan', 'no_urut', 'id_rendak'], 'required'],
            [['no_urut'], 'integer'],
            [['id_tembusan'], 'string', 'max' => 20],
            [['id_rendak'], 'string', 'max' => 16],
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
            'id_rendak' => 'Id Rendak',
            'tembusan' => 'Tembusan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRendak()
    {
        return $this->hasOne(PdmRendak::className(), ['id_rendak' => 'id_rendak']);
    }
}
