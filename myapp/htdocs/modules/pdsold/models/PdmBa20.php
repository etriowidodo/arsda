<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba20".
 *
 * @property string $no_register_perkara
 * @property string $tgl_ba20
 * @property string $lokasi
 * @property string $id_tersangka
 * @property string $bar_buk
 * @property string $nama
 * @property string $pekerjaan
 * @property string $alamat
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $surat_perintah
 * @property string $no_surat_perintah
 * @property string $tgl_surat_perintah
 * @property string $no_putusan
 * @property string $tgl_putusan
 * @property string $no_surat_p16a
 * @property integer $no_urut_jaksa_p16a
 * @property string $saksi
 * @property string $barbuk
 */
class PdmBa20 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba20';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'tgl_ba20', 'created_by', 'updated_by', 'tgl_putusan'], 'required'],
            [['tgl_ba20', 'created_time', 'updated_time', 'tgl_surat_perintah', 'tgl_putusan'], 'safe'],
            [['bar_buk', 'saksi', 'barbuk'], 'string'],
            [['created_by', 'updated_by', 'no_urut_jaksa_p16a'], 'integer'],
            [['no_register_perkara', 'id_tersangka', 'no_surat_perintah', 'no_putusan'], 'string', 'max' => 30],
            [['lokasi', 'pekerjaan', 'alamat'], 'string', 'max' => 128],
            [['nama', 'surat_perintah'], 'string', 'max' => 64],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['no_surat_p16a'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'tgl_ba20' => 'Tgl Ba20',
            'lokasi' => 'Lokasi',
            'id_tersangka' => 'Id Tersangka',
            'bar_buk' => 'Bar Buk',
            'nama' => 'Nama',
            'pekerjaan' => 'Pekerjaan',
            'alamat' => 'Alamat',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'surat_perintah' => 'Surat Perintah',
            'no_surat_perintah' => 'No Surat Perintah',
            'tgl_surat_perintah' => 'Tgl Surat Perintah',
            'no_putusan' => 'No Putusan',
            'tgl_putusan' => 'Tgl Putusan',
            'no_surat_p16a' => 'No Surat P16a',
            'no_urut_jaksa_p16a' => 'No Urut Jaksa P16a',
            'saksi' => 'Saksi',
            'barbuk' => 'Barbuk',
        ];
    }
}
