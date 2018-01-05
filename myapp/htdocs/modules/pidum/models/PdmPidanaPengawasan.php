<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_pidana_pengawasan".
 *
 * @property integer $id
 * @property string $nama
 * @property string $flag
 */
class PdmPidanaPengawasan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_pidana_pengawasan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['nama'], 'string', 'max' => 64],
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
            'nama' => 'Nama',
            'flag' => 'Flag',
        ];
    }
}
