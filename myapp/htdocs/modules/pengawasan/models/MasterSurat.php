<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.master_surat".
 *
 * @property string $id_surat
 * @property string $keterangan
 */
class MasterSurat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.master_surat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_surat'], 'required'],
            [['id_surat'], 'string', 'max' => 20],
            [['keterangan'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_surat' => 'Id Surat',
            'keterangan' => 'Keterangan',
        ];
    }
}
