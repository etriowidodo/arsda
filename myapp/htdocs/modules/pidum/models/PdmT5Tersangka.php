<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_t5_tersangka".
 *
 * @property string $id
 * @property string $id_t5
 * @property string $id_tersangka
 */
class PdmT5Tersangka extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_t5_tersangka';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_t5', 'id_tersangka'], 'required'],
            [['id_t5'], 'string', 'max' => 16],
			[['id'], 'integer'],
            [['id_perkara'], 'string', 'max' => 56],
            [['id_tersangka'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_t5' => 'Id T5',
            'id_tersangka' => 'Id Tersangka',
        ];
    }
}
