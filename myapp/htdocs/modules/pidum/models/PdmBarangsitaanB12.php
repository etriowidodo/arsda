<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_barangsitaan_b12".
 *
 * @property string $id_b12
 * @property integer $id_msbendasitaan
 */
class PdmBarangsitaanB12 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_barangsitaan_b12';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_b12', 'id_msbendasitaan'], 'required'],
            [['id_msbendasitaan'], 'integer'],
            [['id_b12'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_b12' => 'Id B12',
            'id_msbendasitaan' => 'Id Msbendasitaan',
        ];
    }
}
