<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.ms_inst_pelak_penyidikan".
 *
 * @property string $kode_ip
 * @property string $kode_ipp
 * @property string $nama
 * @property string $akronim
 */
class MsInstPelakPenyidikan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.ms_inst_pelak_penyidikan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_ip', 'kode_ipp'], 'required'],
            [['kode_ip'], 'string', 'max' => 2],
            [['kode_ipp'], 'string', 'max' => 12],
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
            'kode_ip' => 'Kode IP',
            'kode_ipp' => 'Kode IPP',
            'nama' => 'Nama',
            'akronim' => 'Akronim',
        ];
    }

    /**
     * @inheritdoc
     * @return MsInstPelakPenyidikanQuery the active query used by this AR class.
     */
 
}
