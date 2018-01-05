<?php

namespace app\modules\pidum\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_p37".
 *
 * @property string $no_register_perkara
 * @property string $no_surat_p37
 * @property integer $id_msstatusdata
 * @property string $tmpt_lahir
 * @property string $tgl_lahir
 * @property string $alamat
 * @property string $no_identitas
 * @property string $no_hp
 * @property integer $warganegara
 * @property string $pekerjaan
 * @property string $suku
 * @property string $nama
 * @property integer $id_jkl
 * @property integer $id_identitas
 * @property integer $id_agama
 * @property integer $id_pendidikan
 * @property string $umur
 * @property string $nama_hadap
 * @property string $alamat_hadap
 * @property string $tgl_hadap
 * @property string $jam
 * @property string $keperluan
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
 * @property string $id_penandatangan
 * @property string $no_reg_tahanan
 * @property string $nip
 * @property string $jabatan
 * @property string $pangkat
 * @property string $id_p37
 * @property integer $id_ms_sts_data
 * @property string $nama_ttd
 * @property string $file_upload
 * @property string $pangkat_ttd
 * @property string $jabatan_ttd
 */
class PdmP37 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_p37';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'nama', 'created_by', 'updated_by', 'id_p37'], 'required'],
            [['id_msstatusdata', 'warganegara', 'id_jkl', 'id_identitas', 'id_agama', 'id_pendidikan', 'created_by', 'updated_by', 'id_ms_sts_data'], 'integer'],
            [['tgl_lahir', 'tgl_hadap', 'jam', 'tgl_dikeluarkan', 'created_time', 'updated_time'], 'safe'],
            [['umur'], 'number'],
            [['alamat_hadap', 'keperluan', 'file_upload'], 'string'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['no_surat_p37'], 'string', 'max' => 50],
            [['tmpt_lahir', 'no_hp', 'suku'], 'string', 'max' => 32],
            [['alamat', 'pangkat_ttd', 'jabatan_ttd'], 'string', 'max' => 150],
            [['no_identitas'], 'string', 'max' => 24],
            [['pekerjaan', 'dikeluarkan'], 'string', 'max' => 64],
            [['nama'], 'string', 'max' => 255],
            [['nama_hadap'], 'string', 'max' => 128],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['id_penandatangan', 'nip'], 'string', 'max' => 20],
            [['no_reg_tahanan', 'id_p37'], 'string', 'max' => 60],
            [['jabatan', 'pangkat', 'nama_ttd'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'no_surat_p37' => 'No Surat P37',
            'id_msstatusdata' => 'Id Msstatusdata',
            'tmpt_lahir' => 'Tmpt Lahir',
            'tgl_lahir' => 'Tgl Lahir',
            'alamat' => 'Alamat',
            'no_identitas' => 'No Identitas',
            'no_hp' => 'No Hp',
            'warganegara' => 'Warganegara',
            'pekerjaan' => 'Pekerjaan',
            'suku' => 'Suku',
            'nama' => 'Nama',
            'id_jkl' => 'Id Jkl',
            'id_identitas' => 'Id Identitas',
            'id_agama' => 'Id Agama',
            'id_pendidikan' => 'Id Pendidikan',
            'umur' => 'Umur',
            'nama_hadap' => 'Nama Hadap',
            'alamat_hadap' => 'Alamat Hadap',
            'tgl_hadap' => 'Tgl Hadap',
            'jam' => 'Jam',
            'keperluan' => 'Keperluan',
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
            'id_penandatangan' => 'Id Penandatangan',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'nip' => 'Nip',
            'jabatan' => 'Jabatan',
            'pangkat' => 'Pangkat',
            'id_p37' => 'Id P37',
            'id_ms_sts_data' => 'Id Ms Sts Data',
            'nama_ttd' => 'Nama Ttd',
            'file_upload' => 'File Upload',
            'pangkat_ttd' => 'Pangkat Ttd',
            'jabatan_ttd' => 'Jabatan Ttd',
        ];
    }
}
