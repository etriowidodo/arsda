<?php

namespace app\modules\pidsus\models;

use Yii;

use yii\data\SqlDataProvider;

/**
 * This is the model class for table "tes".
 *
 * @property integer $id
 * @property string $nama
 * @property string $tes
 */
class Tes extends \yii\db\ActiveRecord
//class Tes extends SqlDataProvider
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'tes'], 'string', 'max' => 100]
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
            'tes' => 'Tes',
        ];
    }
}
