<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.ms_penyidik".
 *
 * @property string $id_penyidik
 * @property string $nama
 * @property string $flag
 *
 * @property PdmSpdp[] $pdmSpdps
 */
class MsPenyidik extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.ms_penyidik';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_penyidik'], 'required'],
            [['id_penyidik'], 'string', 'max' => 32],
            [['nama'], 'string', 'max' => 128],
            [['flag'], 'string', 'max' => 1],
            [['id_penyidik'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_penyidik' => 'Id Penyidik',
            'nama' => 'Nama',
            'flag' => 'Flag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmSpdps()
    {
        return $this->hasMany(PdmSpdp::className(), ['id_penyidik' => 'id_penyidik']);
    }
}
