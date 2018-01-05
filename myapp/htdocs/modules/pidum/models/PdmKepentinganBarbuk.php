<?php

namespace app\modules\pidum\models;

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
class PdmKepentinganBarbuk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_kepentingan_barbuk';
    }

    /**
     * @inheritdoc
     */
    /*public function rules()
    {
        return [
            [['id_barbuk'], 'required'],
            [['no'], 'number'],
            [['k_pembuktian_perkara', 'k_pembuktian_iptek','k_pendidikan_pelatihan','dimusnahkan','id_barbuk'], 'string', 'max' => 256]
        ];
    }*/

    /**
     * @inheritdoc
     */
    /*public function attributeLabels()
    {
        return [
            'id_penetapan_barbuk_surat' => 'Id Penetapan Barbuk Surat',
            'id_sita' => 'Id Penetapan Barbuk',
            'nama_surat' => 'Nama Surat',
            'no_surat' => 'No Surat',
            'tgl_surat' => 'Tgl Surat',
            'tgl_diterima' => 'Tgl Diterima',
        ];
    }*/
}
