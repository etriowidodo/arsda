<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.vw_gridp44".
 *
 * @property string $no_register_perkara
 * @property string $tersangka
 * @property string $undang
 * @property string $pasal
 */
class PdmVwP44 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_gridp44';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tersangka', 'undang', 'pasal'], 'string'],
            [['no_register_perkara'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'tersangka' => 'Tersangka',
            'undang' => 'Undang',
            'pasal' => 'Pasal',
        ];
    }
}
