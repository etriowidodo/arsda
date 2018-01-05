<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.ms_pasal".
 *
 * @property string $uu
 * @property string $pasal
 * @property string $bunyi
 */
class MsPasal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.ms_pasal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uu', 'pasal'], 'required'],
            [['uu'], 'string', 'max' => 50],
            [['pasal'], 'string', 'max' => 100],
            [['bunyi'], 'string', 'max' => 400],
			[['uu', 'pasal'], 'unique', 'targetAttribute' => ['uu', 'pasal']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uu' => 'Uu',
            'pasal' => 'Pasal',
            'bunyi' => 'Bunyi',
        ];
    }
}
