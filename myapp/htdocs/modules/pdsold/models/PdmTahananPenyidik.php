<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_tahanan_penyidik".
 *
 * @property string $id
 * @property string $id_perkara
 * @property string $id_tersangka
 * @property integer $id_msloktahanan
 * @property string $tgl_mulai
 * @property string $tgl_selesai
 * @property string $lokasi_rutan
 * @property string $flag
 */
class PdmTahananPenyidik extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_tahanan_penyidik';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id_msloktahanan'], 'integer'],
            [['tgl_mulai', 'tgl_selesai'], 'safe'],
            [['id', 'id_tersangka', 'id_berkas'], 'string', 'max' => 16],
			[['id_perkara'], 'string', 'max' => 56],
            [['lokasi_rutan'], 'string', 'max' => 255],
            [['flag'], 'string', 'max' => 1],
			[['tgl_selesai'], 'compare','compareAttribute'=>'tgl_mulai','operator'=>'>=','message'=>'Tanggal Selesai tidak boleh lebih kecil dari Tanggal Mulai'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_perkara' => 'Id Perkara',
            'id_tersangka' => 'Id Tersangka',
            'id_msloktahanan' => 'Id Msloktahanan',
            'tgl_mulai' => 'Tgl Mulai',
            'tgl_selesai' => 'Tgl Selesai',
            'lokasi_rutan' => 'Lokasi Rutan',
            'flag' => 'Flag',
        ];
    }
}
