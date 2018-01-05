<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.ms_inst_penyidik".
 *
 * @property string $kode_ip
 * @property string $nama
 * @property string $akronim
 */
class MsInstPenyidik extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.ms_inst_penyidik';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_ip'], 'required'],
            [['kode_ip'], 'string', 'max' => 2],
            [['nama'], 'string', 'max' => 100],
            [['akronim'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode_ip' => 'Kode Ip',
            'nama' => 'Nama',
            'akronim' => 'Akronim',
        ];
    }

    /**
     * @inheritdoc
     * @return MsInstPenyidikQuery the active query used by this AR class.
     */
 
}
