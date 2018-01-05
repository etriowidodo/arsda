<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tsk_keterangan".
 *
 * @property string $id_tsk_keterangan
 * @property string $id_ba15
 * @property string $pertanyaan
 * @property string $jawaban
 * @property string $id_perkara
 * @property string $flag
 */
class PdmTskKeterangan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tsk_keterangan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tsk_keterangan', 'id_perkara'], 'required'],
            [['pertanyaan', 'jawaban'], 'string'],
            [['id_tsk_keterangan', 'id_perkara'], 'string', 'max' => 16],
            [['id_ba15'], 'string', 'max' => 32],
            [['flag'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tsk_keterangan' => 'Id Tsk Keterangan',
            'id_ba15' => 'Id Ba15',
            'pertanyaan' => 'Pertanyaan',
            'jawaban' => 'Jawaban',
            'id_perkara' => 'Id Perkara',
            'flag' => 'Flag',
        ];
    }
}
