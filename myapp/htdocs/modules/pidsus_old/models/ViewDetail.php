<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "simkari.view_detail".
 *
 * @property integer $id_detail
 * @property string $nama_detail
 */
class ViewDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'simkari.view_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_detail'], 'integer'],
            [['nama_detail'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_detail' => 'Id Detail',
            'nama_detail' => 'Nama Detail',
        ];
    }
}
