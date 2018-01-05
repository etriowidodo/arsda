<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.ms_jenis_pidana".
 *
 * @property integer $kode_pidana
 * @property string $nama
 * @property string $akronim
 */
class MsJenisPidana extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.ms_jenis_pidana';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_pidana'], 'required'],
            //[['kode_pidana'], 'unique'],
            //[['kode_pidana'], 'integer'],
            [['nama'], 'string', 'max' => 50],
            [['akronim'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'kode_pidana' => 'Kode Pidana',
            'nama' => 'Nama',
            'akronim' => 'Akronim',
        ];
    }
}
