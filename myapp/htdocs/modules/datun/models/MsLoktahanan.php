<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.ms_loktahanan".
 *
 * @property integer $id_loktahanan
 * @property string $nama
 * @property string $flag
 *
 * @property PdmT4[] $pdmT4s
 */
class MsLoktahanan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.ms_loktahanan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_loktahanan', 'nama'], 'required'],
            [['id_loktahanan'], 'integer'],
            [['nama'], 'string', 'max' => 20],
            [['flag'], 'string', 'max' => 1],
            [['id_loktahanan'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_loktahanan' => 'Id Loktahanan',
            'nama' => 'Nama',
            'flag' => 'Flag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPdmT4s()
    {
        return $this->hasMany(PdmT4::className(), ['id_loktahanan' => 'id_loktahanan']);
    }
}
