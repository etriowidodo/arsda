<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba20_eks".
 *
 * @property string $no_register_perkara
 * @property string $no_akta
 * @property string $no_reg_tahanan
 * @property string $no_eksekusi
 * @property string $tgl_ba20
 * @property string $lokasi
 * @property string $id_tersangka
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
 * @property string $no_surat_p16a
 * @property integer $no_urut_jaksa_p16a
 * @property string $saksi
 */
class PdmBa20Eks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba20_eks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_akta', 'no_reg_tahanan', 'no_eksekusi', 'tgl_ba20', 'created_by', 'updated_by'], 'required'],
            [['tgl_ba20', 'created_time', 'updated_time', 'tgl_surat_perintah'], 'safe'],
            [['created_by', 'updated_by', 'no_urut_jaksa_p16a'], 'integer'],
            [['saksi'], 'string'],
            [['no_register_perkara', 'no_akta', 'no_surat_perintah'], 'string', 'max' => 30],
            [['no_reg_tahanan', 'no_eksekusi'], 'string', 'max' => 30],
            [['lokasi', 'pekerjaan', 'alamat'], 'string', 'max' => 128],
            [['id_tersangka', 'no_surat_p16a'], 'string', 'max' => 50],
            [['terpidana'], 'string', 'max' => 100],
            [['nama', 'surat_perintah'], 'string', 'max' => 64],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_akta' => 'No Akta',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'no_eksekusi' => 'No Eksekusi',
            'tgl_ba20' => 'Tgl Ba20',
            'lokasi' => 'Lokasi',
            'id_tersangka' => 'Id Tersangka',
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
            'no_surat_p16a' => 'No Surat P16a',
            'no_urut_jaksa_p16a' => 'No Urut Jaksa P16a',
            'saksi' => 'Saksi',
        ];
    }
}
