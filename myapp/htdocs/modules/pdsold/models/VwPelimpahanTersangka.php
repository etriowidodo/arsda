<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.vw_pelimpahan_tersangka".
 *
 * @property string $id_perkara
 * @property string $nama_tersangka
 * @property string $nama_tahanan
 * @property string $lokasi_rutan
 * @property string $tgl_mulai
 * @property string $tgl_selesai
 */
class VwPelimpahanTersangka extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.vw_pelimpahan_tersangka';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_mulai', 'tgl_selesai'], 'safe'],
            [['id_perkara'], 'string', 'max' => 16],
            [['nama_tersangka', 'lokasi_rutan'], 'string', 'max' => 255],
            [['nama_tahanan'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perkara' => 'Id Perkara',
            'nama_tersangka' => 'Nama Tersangka',
            'nama_tahanan' => 'Nama Tahanan',
            'lokasi_rutan' => 'Lokasi Rutan',
            'tgl_mulai' => 'Tgl Mulai',
            'tgl_selesai' => 'Tgl Selesai',
        ];
    }
}
