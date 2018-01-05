<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.surat_peraturan".
 *
 * @property string $id
 * @property string $id_surat
 * @property string $id_peraturan
 */
class SuratPeraturan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.surat_peraturan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id', 'id_surat', 'id_peraturan'], 'required'],
            [['id', 'id_surat', 'id_peraturan'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_surat' => 'Id Surat',
            'id_peraturan' => 'Id Peraturan',
        ];
    }
}
