<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.ms_asalsurat".
 *
 * @property string $id_asalsurat
 * @property string $nama
 * @property string $flag
 *
 * @property PdmSpdp[] $pdmSpdps
 */
class MsAsalsurat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.ms_asalsurat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_asalsurat'], 'required'],
            [['id_asalsurat'], 'string', 'max' => 32],
            [['nama'], 'string', 'max' => 20],
            [['flag'], 'string', 'max' => 1],
            [['id_asalsurat'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_asalsurat' => 'Id Asalsurat',
            'nama' => 'Nama',
            'flag' => 'Flag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmSpdps()
    {
        return $this->hasMany(PdmSpdp::className(), ['id_asalsurat' => 'id_asalsurat']);
    }
}
