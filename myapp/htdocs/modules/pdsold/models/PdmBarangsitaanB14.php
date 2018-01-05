<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_barangsitaan_b14".
 *
 * @property string $id_b14
 * @property integer $id_msbendasitaan
 */
class PdmBarangsitaanB14 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_barangsitaan_b14';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_b14', 'id_msbendasitaan'], 'required'],
            [['id_msbendasitaan'], 'integer'],
            [['id_b14'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_b14' => 'Id B14',
            'id_msbendasitaan' => 'Id Msbendasitaan',
        ];
    }
}
