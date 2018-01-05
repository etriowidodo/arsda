<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.ms_peraturan".
 *
 * @property string $id_peraturan
 * @property string $nama_peraturan
 */
class MsPeraturan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.ms_peraturan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id_peraturan'], 'required'],
            [['id_peraturan'], 'integer'],
            [['nama_peraturan'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_peraturan' => 'Id Peraturan',
            'nama_peraturan' => 'Nama Peraturan',
        ];
    }
}
