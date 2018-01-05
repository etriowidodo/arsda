<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_penetapan_barbuk_surat".
 *
 * @property string $id_penetapan_barbuk_surat
 * @property string $id_penetapan_barbuk
 * @property string $nama_surat
 * @property string $no_surat
 * @property string $tgl_surat
 * @property string $tgl_diterima
 */
class PdmPenetapanBarbukSurat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_penetapan_barbuk_surat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_penetapan_barbuk_surat', 'id_sita'], 'required'],
            [['tgl_surat', 'tgl_diterima'], 'safe'],
            [['id_penetapan_barbuk_surat'], 'string', 'max' => 16],
            [['id_sita'], 'string', 'max' => 56],
            [['nama_surat', 'no_surat'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_penetapan_barbuk_surat' => 'Id Penetapan Barbuk Surat',
            'id_sita' => 'Id Penetapan Barbuk',
            'nama_surat' => 'Nama Surat',
            'no_surat' => 'No Surat',
            'tgl_surat' => 'Tgl Surat',
            'tgl_diterima' => 'Tgl Diterima',
        ];
    }
}
