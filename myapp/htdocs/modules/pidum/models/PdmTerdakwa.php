<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_terdakwa".
 *
 * @property string $id_tersangka
 * @property string $id_ba15
 */
class PdmTerdakwa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_terdakwa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tersangka'], 'required'],
            [['id_tersangka'], 'string', 'max' => 20],
           [['id_ba14'], 'string', 'max' => 25],
			[['id_ba15'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tersangka' => 'Id Tersangka',
           'id_ba14' => 'Id Ba14',
			'id_ba15' => 'Id Ba15',
        ];
    }

    public function getTerdakwa()
    {
        return $this->hasOne(VwTerdakwa::className(), ['id_tersangka' => 'id_tersangka']);
    }
}
