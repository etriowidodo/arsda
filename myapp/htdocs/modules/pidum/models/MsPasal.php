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
            [['id','id_pasal', 'pasal'], 'required'],
            [['id'], 'string', 'max' => 2],
            [['id_pasal'], 'string', 'max' => 3],
            [['pasal'], 'string', 'max' => 100],
            [['bunyi'], 'string', 'max' => 400],
			[['id', 'id_pasal'], 'unique', 'targetAttribute' => ['id', 'id_pasal']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID UU',
            'id_pasal' => 'ID Pasal',
            'pasal' => 'Pasal',
            'bunyi' => 'Bunyi',
        ];
    }
}
