<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p34".
 *
 * @property string $no_register_perkara
 * @property string $tgl_surat_p34
 * @property string $jam
 * @property string $id_tersangka
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $barbuk
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $nip_jaksa
 * @property string $lokasi_pengadilan
 * @property string $penerima
 * @property string $file_upload
 */
class PdmP34 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p34';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'tgl_surat_p34', 'created_by', 'updated_by'], 'required'],
            [['tgl_surat_p34', 'jam', 'tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['barbuk', 'file_upload'], 'string'],
            [['created_by', 'updated_by'], 'integer'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['id_tersangka'], 'string', 'max' => 16],
            [['dikeluarkan'], 'string', 'max' => 64],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['nip_jaksa'], 'string', 'max' => 60],
            [['lokasi_pengadilan', 'penerima'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'tgl_surat_p34' => 'Tgl Surat P34',
            'jam' => 'Jam',
            'id_tersangka' => 'Id Tersangka',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'barbuk' => 'Barbuk',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'nip_jaksa' => 'Nip Jaksa',
            'lokasi_pengadilan' => 'Lokasi Pengadilan',
            'penerima' => 'Penerima',
            'file_upload' => 'File Upload',
        ];
    }
}
