<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ms_uu".
 *
 * @property integer $id
 * @property string $uu
 * @property string $keterangan
 * @property string $jns_uu
 * @property string $keyword
 * @property string $flag
 */
class PdmMsUu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ms_uu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uu'], 'required'],
            [['uu'], 'string', 'max' => 200],
            [['keterangan', 'keyword'], 'string', 'max' => 2000],
            [['jns_uu'], 'string', 'max' => 32],
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
            'uu' => 'Uu',
            'keterangan' => 'Keterangan',
            'jns_uu' => 'Jns Uu',
            'keyword' => 'Keyword',
            'flag' => 'Flag',
        ];
    }
}
