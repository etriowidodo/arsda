<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tembusan_p47".
 *
 * @property string $no_register_perkara
 * @property string $no_akta
 * @property integer $no_urut
 * @property string $tembusan
 */
class PdmTembusanP47 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tembusan_p47';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_akta', 'no_urut'], 'required'],
            [['no_urut'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_akta'], 'string', 'max' => 50],
            [['tembusan'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_akta' => 'No Akta',
            'no_urut' => 'No Urut',
            'tembusan' => 'Tembusan',
        ];
    }
}
