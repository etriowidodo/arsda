<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\data\SqlDataProvider;
/**
 * This is the model class for table "tesQ".
 *
 * @property integer $id
 * @property string $nama
 * @property string $tes
 */
class TesQ extends SqlDataProvider
{
    /**
     * @inheritdoc
     */
    public function viewTes()
    {

    }
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
