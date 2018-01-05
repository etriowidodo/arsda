<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_drop_was13".
 *
 * @property string $id_register
 * @property integer $persuratan
 * @property string $id_surat
 * @property string $surat
 * @property string $no_surat
 * @property string $tgl_surat
 */
class VDropWas13 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_drop_was13';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['persuratan'], 'integer'],
            [['surat', 'no_surat'], 'string'],
            [['tgl_surat'], 'safe'],
            [['id_register', 'id_surat'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_register' => 'Id Register',
            'persuratan' => 'Persuratan',
            'id_surat' => 'Id Surat',
            'surat' => 'Surat',
            'no_surat' => 'No Surat',
            'tgl_surat' => 'Tgl Surat',
        ];
    }
}
