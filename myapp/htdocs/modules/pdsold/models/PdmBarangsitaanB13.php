<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_barangsitaan_b13".
 *
 * @property string $id_b13
 * @property integer $id_msbendasitaan
 */
class PdmBarangsitaanB13 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_barangsitaan_b13';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_b13', 'id_msbendasitaan'], 'required'],
            [['id_msbendasitaan'], 'integer'],
            [['id_b13'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_b13' => 'Id B13',
            'id_msbendasitaan' => 'Id Msbendasitaan',
        ];
    }
}
