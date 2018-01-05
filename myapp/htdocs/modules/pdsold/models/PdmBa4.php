<?php

namespace app\modules\pdsold\models;

use Yii;

/**
 * This is the model class for table "pidum.pdm_ba4_tersangka".
 *
 * @property string $no_register_perkara
 * @property string $tgl_ba4
 * @property string $id_peneliti
 * @property string $no_reg_tahanan
 * @property string $no_reg_perkara
 * @property string $alasan
 * @property string $id_penandatangan
 * @property string $upload_file
 * @property integer $no_urut_tersangka
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
 * @property string $id_kejati
 * @property string $id_kejari
 * @property string $id_cabjari
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property string $nama_ttd
 * @property string $pangkat_ttd
 * @property string $jabatan_ttd
 * @property string $updated_time
 * @property string $created_by
 * @property string $updated_by
 * @property string $foto
 * @property resource $upload_file2
 * @property string $tgl_awal_penyidik
 * @property string $tgl_akhir_penyidik
 * @property string $tgl_awal_kejaksaan
 * @property string $tgl_akhir_kejaksaan
 * @property string $tgl_awal_pn
 * @property string $tgl_akhir_pn
 * @property string $no_sp_penyidik
 * @property string $no_sp_jaksa
 * @property string $no_sp_pn
 * @property string $tgl_sp_penyidik
 * @property string $tgl_sp_jaksa
 * @property string $tgl_sp_pn
 * @property integer $jns_penahanan_penyidik
 * @property integer $jns_penahanan_jaksa
 * @property integer $jns_penahanan_pn
 * @property string $lokasi_penyidik
 * @property string $lokasi_jaksa
 * @property string $lokasi_pn
 */
class PdmBa4 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pidum.pdm_ba4_tersangka';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'tgl_ba4', 'no_urut_tersangka'], 'required'],
            [['tgl_ba4', 'tgl_lahir', 'created_time', 'updated_time', 'tgl_awal_penyidik', 'tgl_akhir_penyidik', 'tgl_awal_kejaksaan', 'tgl_akhir_kejaksaan', 'tgl_awal_pn', 'tgl_akhir_pn', 'tgl_sp_penyidik', 'tgl_sp_jaksa', 'tgl_sp_pn'], 'safe'],
            [['alasan', 'upload_file', 'foto', 'upload_file2'], 'string'],
            [['no_urut_tersangka', 'warganegara', 'id_jkl', 'id_identitas', 'id_agama', 'id_pendidikan', 'jns_penahanan_penyidik', 'jns_penahanan_jaksa', 'jns_penahanan_pn'], 'integer'],
            [['umur'], 'number'],
            [['no_register_perkara'], 'string', 'max' => 30],
            [['id_peneliti', 'tmpt_lahir', 'no_hp', 'suku'], 'string', 'max' => 32],
            [['no_reg_tahanan', 'no_reg_perkara', 'id_penandatangan'], 'string', 'max' => 30],
            [['alamat'], 'string', 'max' => 150],
            [['no_identitas'], 'string', 'max' => 24],
            [['pekerjaan'], 'string', 'max' => 64],
            [['nama'], 'string', 'max' => 255],
            [['id_kejati', 'id_kejari', 'id_cabjari'], 'string', 'max' => 2],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['nama_ttd', 'jabatan_ttd'], 'string', 'max' => 200],
            [['pangkat_ttd'], 'string', 'max' => 100],
            [['created_by', 'updated_by'], 'string', 'max' => 18],
            [['no_sp_penyidik', 'no_sp_jaksa', 'no_sp_pn', 'lokasi_jaksa', 'lokasi_pn'], 'string', 'max' => 40],
            [['lokasi_penyidik'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_register_perkara' => 'No Register Perkara',
            'tgl_ba4' => 'Tgl Ba4',
            'id_peneliti' => 'Id Peneliti',
            'no_reg_tahanan' => 'No Reg Tahanan',
            'no_reg_perkara' => 'No Reg Perkara',
            'alasan' => 'Alasan',
            'id_penandatangan' => 'Id Penandatangan',
            'upload_file' => 'Upload File',
            'no_urut_tersangka' => 'No Urut Tersangka',
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
            'id_kejati' => 'Id Kejati',
            'id_kejari' => 'Id Kejari',
            'id_cabjari' => 'Id Cabjari',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'nama_ttd' => 'Nama Ttd',
            'pangkat_ttd' => 'Pangkat Ttd',
            'jabatan_ttd' => 'Jabatan Ttd',
            'updated_time' => 'Updated Time',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'foto' => 'Foto',
            'upload_file2' => 'Upload File2',
            'tgl_awal_penyidik' => 'Tgl Awal Penyidik',
            'tgl_akhir_penyidik' => 'Tgl Akhir Penyidik',
            'tgl_awal_kejaksaan' => 'Tgl Awal Kejaksaan',
            'tgl_akhir_kejaksaan' => 'Tgl Akhir Kejaksaan',
            'tgl_awal_pn' => 'Tgl Awal Pn',
            'tgl_akhir_pn' => 'Tgl Akhir Pn',
            'no_sp_penyidik' => 'No Sp Penyidik',
            'no_sp_jaksa' => 'No Sp Jaksa',
            'no_sp_pn' => 'No Sp Pn',
            'tgl_sp_penyidik' => 'Tgl Sp Penyidik',
            'tgl_sp_jaksa' => 'Tgl Sp Jaksa',
            'tgl_sp_pn' => 'Tgl Sp Pn',
            'jns_penahanan_penyidik' => 'Jns Penahanan Penyidik',
            'jns_penahanan_jaksa' => 'Jns Penahanan Jaksa',
            'jns_penahanan_pn' => 'Jns Penahanan Pn',
            'lokasi_penyidik' => 'Lokasi Penyidik',
            'lokasi_jaksa' => 'Lokasi Jaksa',
            'lokasi_pn' => 'Lokasi Pn',
        ];
    }
}
