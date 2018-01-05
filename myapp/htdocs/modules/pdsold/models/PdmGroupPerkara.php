<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_group_perkara".
 *
 * @property integer $id_grpperkara
 * @property string $nama
 */
class PdmGroupPerkara extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_group_perkara';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_grpperkara'], 'required'],
            [['id_grpperkara'], 'integer'],
            [['nama'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_grpperkara' => 'Id Grpperkara',
            'nama' => 'Nama',
        ];
    }
}
