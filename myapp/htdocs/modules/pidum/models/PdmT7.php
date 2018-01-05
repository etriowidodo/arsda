<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_t7".
 *
 * @property string $id_t7
 * @property string $no_register_perkara
 * @property string $no_surat
 * @property string $undang
 * @property string $tahun
 * @property string $tentang
 * @property string $id_tersangka
 * @property string $penahanan_dari
 * @property string $no_surat_perintah
 * @property string $tgl_srt_perintah
 * @property integer $id_ms_loktahanan
 * @property string $lokasi_tahanan
 * @property integer $lama
 * @property string $tgl_mulai
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_penandatangan
 * @property string $upload_file
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property integer $tindakan_status
 *
 * @property PdmMsTindakanStatus $tindakanStatus
 */
class PdmT7 extends \app\models\BaseModel
{
    public $jenis_penahanan;
    public $tahanan;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_t7';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'tgl_dikeluarkan','tindakan_status','nama_tersangka_ba4','id_ms_loktahanan'], 'required'],
            [['tentang'], 'string'],
            [['tgl_srt_perintah', 'tgl_mulai','tgl_selesai', 'tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['id_ms_loktahanan', 'lama', 'created_by', 'updated_by', 'tindakan_status'], 'integer'],
            [[ 'no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_t7', 'no_surat_perintah'], 'string', 'max' => 32],
            [['undang', 'penahanan_dari'], 'string', 'max' => 200],
            [['tahun'], 'string', 'max' => 4],
            [['lokasi_tahanan'], 'string', 'max' => 128],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['id_penandatangan'], 'string', 'max' => 20],
            // [['upload_file'], 'string', 'max' => 100],
            // [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'id_t7' => 'Id T7',
            'no_register_perkara' => 'Id Perkara',
            'no_surat_t7' => 'No Surat T7',
            'nama_jaksa' => 'Nama Jaksa',
            'nama_tersangka_ba4' => 'Nama Tersangka',
            'tentang' => 'Tentang',
            'id_ms_loktahanan' => 'Lokasi Tahanan',
            // 'id_tersangka' => 'Id Tersangka',
            'penahanan_dari' => 'Penahanan Dari',
            'no_surat_perintah' => 'No Surat Perintah',
            'tgl_srt_perintah' => 'Tgl Srt Perintah',
            'id_ms_loktahanan' => 'Lokasi Tahana',
            'lokasi_tahanan' => 'Lokasi Tahanan',
            'lama' => 'Lama',
            'tgl_mulai' => 'Tgl Mulai',
			  'tgl_selesai' => 'Tgl selesai',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_penandatangan' => 'Id Penandatangan',
            'upload_file' => 'Upload File',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'tindakan_status' => 'Tindakan Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTindakanStatus()
    {
        return $this->hasOne(PdmMsTindakanStatus::className(), ['id' => 'tindakan_status']);
    }

    public function getLokTahanan()
    {
        return $this->hasOne(MsLoktahanan::className(), ['id_loktahanan' => 'id_ms_loktahanan']);
    }

    public function getJpu()
    {
        return $this->hasOne(PdmJaksaSaksi::className(), ['no_register_perkara' => 'no_register_perkara']);
    }

    public function getTersangka() {
        return $this->hasOne(MsTersangka::className(), ['id_tersangka' => 'id_tersangka']);
    }
}
