<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.vw_tahanan_penyidik".
 *
 * @property string $id_perkara
 * @property string $id_tersangka
 * @property integer $id_msloktahanan
 * @property string $tgl_mulai
 * @property string $tgl_selesai
 * @property string $lokasi_rutan
 * @property string $nama
 * @property string $tmpt_lahir
 * @property string $tgl_lahir
 * @property string $alamat
 * @property string $no_identitas
 * @property string $warganegara
 */
class VwTahananPenyidik extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_tahanan_penyidik';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_msloktahanan'], 'integer'],
            [['tgl_mulai', 'tgl_selesai', 'tgl_lahir'], 'safe'],
            [['id_perkara', 'id_tersangka'], 'string', 'max' => 16],
            [['lokasi_rutan', 'nama'], 'string', 'max' => 255],
            [['tmpt_lahir'], 'string', 'max' => 32],
            [['alamat'], 'string', 'max' => 128],
            [['no_identitas'], 'string', 'max' => 24],
            [['warganegara'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perkara' => 'Id Perkara',
            'id_tersangka' => 'Id Tersangka',
            'id_msloktahanan' => 'Id Msloktahanan',
            'tgl_mulai' => 'Tgl Mulai',
            'tgl_selesai' => 'Tgl Selesai',
            'lokasi_rutan' => 'Lokasi Rutan',
            'nama' => 'Nama',
            'tmpt_lahir' => 'Tmpt Lahir',
            'tgl_lahir' => 'Tgl Lahir',
            'alamat' => 'Alamat',
            'no_identitas' => 'No Identitas',
            'warganegara' => 'Warganegara',
        ];
    }
}
