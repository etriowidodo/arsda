<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_penetapan_barbuk".
 *
 * @property string $id_penetapan_barbuk
 * @property string $no_penetapan
 * @property string $tersangka
 * @property string $id_inst_penyidik
 * @property string $id_inst_penyidik_pelaksana
 * @property string $tgl_surat
 * @property string $dikeluarkan
 * @property string $k_pembuktian_perkara
 * @property string $k_pengembangan_iptek
 * @property string $k_pendidikan_pelatihan
 * @property string $dimusnahkan
 * @property string $id_penandatangan
 * @property string $nama
 * @property string $pangkat
 * @property string $jabatan
 * @property string $file_upload
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 */
class PdmPenetapanBarbuk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
	 
     */
	 
	 
    public static function tableName()
    {
        return 'pidum.pdm_penetapan_barbuk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sita','no_penetapan'], 'required'],
            [['tgl_surat', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_sita','id_perkara'], 'string', 'max' => 56],
            [['no_penetapan'], 'string', 'max' => 50],
            [['tersangka'], 'string', 'max' => 255],
            [['id_inst_penyidik', 'id_inst_penyidik_pelaksana'], 'string', 'max' => 32],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['k_pembuktian_perkara', 'k_pengembangan_iptek', 'k_pendidikan_pelatihan', 'dimusnahkan'], 'string', 'max' => 1000],
            [['id_penandatangan'], 'string', 'max' => 20],
            [['nama', 'jabatan'], 'string', 'max' => 200],
            [['pangkat', 'file_upload'], 'string', 'max' => 100],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_penetapan' => 'No Penetapan',
            'tersangka' => 'Tersangka',
            'id_inst_penyidik' => 'Id Inst Penyidik',
            'id_inst_penyidik_pelaksana' => 'Id Inst Penyidik Pelaksana',
            'tgl_surat' => 'Tgl Surat',
            'dikeluarkan' => 'Dikeluarkan',
            'k_pembuktian_perkara' => 'K Pembuktian Perkara',
            'k_pengembangan_iptek' => 'K Pengembangan Iptek',
            'k_pendidikan_pelatihan' => 'K Pendidikan Pelatihan',
            'dimusnahkan' => 'Dimusnahkan',
            'id_penandatangan' => 'Id Penandatangan',
            'nama' => 'Nama',
            'pangkat' => 'Pangkat',
            'jabatan' => 'Jabatan',
            'file_upload' => 'File Upload',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
        ];
    }
}
