<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tanya_jawab".
 *
 * @property string $id
 * @property string $kode_table
 * @property string $id_table
 * @property string $pertanyaan
 * @property string $jawaban
 * @property string $flag
 */
class PdmTanyaJawab extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tanya_jawab';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['pertanyaan', 'jawaban'], 'string'],
            [['id'], 'string', 'max' => 100],
            [['kode_table', 'id_table'], 'string', 'max' => 100],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_table' => 'Kode Table',
            'id_table' => 'Id Table',
            'pertanyaan' => 'Pertanyaan',
            'jawaban' => 'Jawaban',
            'flag' => 'Flag',
        ];
    }
}
