<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba11".
 *
 * @property string $id_ba11
 * @property string $id_berkas
 * @property string $tgl_surat
 * @property string $reg_nomor
 * @property string $reg_perkara
 * @property string $tahanan
 * @property string $ke_tahanan
 * @property string $tgl_mulai
 * @property string $kepala_rutan
 * @property string $id_perkara
 * @property string $flag
 */
class PdmBa8 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba8';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara','tgl_ba8','tahanan','ke_tahanan','kepala_rutan','nama_tersangka_ba4'], 'required'],
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ba11' => 'Id Ba11',
            'id_perkara' => 'Id Perkara',
            'id_berkas' => 'Id Berkas',
            'tgl_ba8' => 'Tgl Berita Acara',
            'is_jaksa' => 'Is Jaksa',
            'no_sp' => 'No SP',
            'tgl_no_sp' => 'Tgl No SP',
            'asal_satker' => 'Asal Satker',
            'id_tersangka' => 'Id Tersangka',
            'reg_nomor' => 'Reg Nomor',
            'reg_perkara' => 'Reg Perkara',
            'tahanan' => 'Tahanan',
            'ke_tahanan' => 'Ke Tahanan',
            'tgl_mulai' => 'Tgl Mulai',
            'kepala_rutan' => 'Kepala Rutan',
            'flag' => 'Flag',
            // 'uploaded_file' => 'uploaded_file',
        ];
    }


    public function getLokTahanan($id)
    {
        return $this->hasOne(MsLoktahanan::className(), ['id_loktahanan' => $id]);
    }

    // public function getLokTahanan2()
    // {
    //     return $this->hasOne(MsLoktahanan::className(), ['id_loktahanan' => 'ke_tahanan']);
    // }
}
