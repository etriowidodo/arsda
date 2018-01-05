<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tanya_ba4".
 *
 * @property string $id_tanya_ba4
 * @property string $id_ba4
 * @property string $pertanyaan
 * @property string $jawaban
 * @property string $id_perkara
 * @property string $flag
 */
class PdmTanyaBa4 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tanya_ba4';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tanya_ba4', 'id_perkara'], 'required'],
            [['pertanyaan', 'jawaban'], 'string'],
            [['id_tanya_ba4', 'id_perkara'], 'string', 'max' => 16],
            [['id_ba4'], 'string', 'max' => 32],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tanya_ba4' => 'Id Tanya Ba4',
            'id_ba4' => 'Id Ba4',
            'pertanyaan' => 'Pertanyaan',
            'jawaban' => 'Jawaban',
            'id_perkara' => 'Id Perkara',
            'flag' => 'Flag',
        ];
    }
}
