<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_uu_pasal_tahap1".
 *
 * @property string $id_pengantar
 * @property string $undang
 * @property string $pasal
 * @property string $dakwaan
 * @property string $id_pasal
 * @property string $tentang
 */
class PdmUuPasalTahap1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_uu_pasal_tahap1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pengantar', 'id_pasal'], 'required'],
            [['id_pengantar'], 'string', 'max' => 135],
            [['undang', 'id_pasal', 'tentang'], 'string', 'max' => 100],
            [['pasal', 'dakwaan'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pengantar' => 'Id Pengantar',
            'undang' => 'Undang',
            'pasal' => 'Pasal',
            'dakwaan' => 'Dakwaan',
            'id_pasal' => 'Id Pasal',
            'tentang' => 'Tentang',
        ];
    }
}
