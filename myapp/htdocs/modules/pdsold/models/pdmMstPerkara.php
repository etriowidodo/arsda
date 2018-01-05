<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_mst_perkara".
 *
 * @property integer $id
 * @property string $nama
 */
class pdmMstPerkara extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_mst_perkara';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama'], 'string', 'max' => 64]
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
        ];
    }

    /**
     * @inheritdoc
     * @return pdmMstPerkaraQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new pdmMstPerkaraQuery(get_called_class());
    }
}
