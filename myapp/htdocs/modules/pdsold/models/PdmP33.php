<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p33".
 *
 * @property string $no_register_perkara
 * @property string $tgl_p33
 * @property string $jam
 * @property string $nama
 * @property string $alamat
 * @property string $pekerjaan
 * @property string $dikeluarkan
 * @property string $tgl_dikeluarkan
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $nip_pegawai
 * @property string $nama_pegawai
 * @property string $pangkat_pegawai
 * @property string $file_upload
 */
class PdmP33 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p33';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'tgl_p33', 'created_by', 'updated_by'], 'required'],
            [['tgl_p33', 'jam', 'tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['file_upload'], 'string'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['nama', 'pekerjaan', 'dikeluarkan', 'nip_pegawai', 'nama_pegawai', 'pangkat_pegawai'], 'string', 'max' => 64],
            [['alamat'], 'string', 'max' => 128],
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
            'tgl_p33' => 'Tgl P33',
            'jam' => 'Jam',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'pekerjaan' => 'Pekerjaan',
            'dikeluarkan' => 'Dikeluarkan',
            'tgl_dikeluarkan' => 'Tgl Dikeluarkan',
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'nip_pegawai' => 'Nip Pegawai',
            'nama_pegawai' => 'Nama Pegawai',
            'pangkat_pegawai' => 'Pangkat Pegawai',
            'file_upload' => 'File Upload',
        ];
    }
}
