<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_was9".
 *
 * @property string $id_was9
 * @property string $tanggal_was9
 * @property string $perihal_was9
 * @property string $lampiran_was9
 * @property string $id_saksi_was9
 * @property string $no_register
 * @property string $jenis_saksi
 * @property string $nip
 * @property string $hari_pemeriksaan_was9
 * @property string $tanggal_pemeriksaan_was9
 * @property string $jam_pemeriksaan_was9
 * @property string $tempat_pemeriksaan_was9
 * @property string $nip_penandatangan
 * @property string $nama_penandatangan
 * @property string $pangkat_penandatangan
 * @property string $golongan_penandatangan
 * @property string $jabatan_penandatangan
 * @property string $was9_file
 * @property string $id_sp_was
 * @property string $sifat_was9
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $nomor_surat_was9
 * @property string $inst_satkerkd
 * @property string $zona
 * @property string $inst_nama
 * @property string $inst_lokinst
 * @property string $id_jabatan
 */
class vWas9 extends \app\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_was9';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tanggal_was9', 'tanggal_pemeriksaan_was9', 'jam_pemeriksaan_was9', 'created_time', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['id_was9'], 'string', 'max' => 16],
            [['perihal_was9', 'tempat_pemeriksaan_was9'], 'string', 'max' => 1000],
            [['lampiran_was9'], 'string', 'max' => 20],
            [['id_saksi_was9', 'nip', 'nip_penandatangan'], 'string', 'max' => 18],
            [['no_register', 'id_sp_was'], 'string', 'max' => 25],
            [['jenis_saksi'], 'string', 'max' => 9],
            [['hari_pemeriksaan_was9', 'sifat_was9'], 'string', 'max' => 6],
            [['nama_penandatangan', 'pangkat_penandatangan', 'was9_file'], 'string', 'max' => 30],
            [['golongan_penandatangan', 'zona'], 'string', 'max' => 5],
            [['jabatan_penandatangan','jbtn_penandatangan'], 'string', 'max' => 65],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['nomor_surat_was9'], 'string', 'max' => 50],
            [['inst_satkerkd'], 'string', 'max' => 10],
            [['inst_nama', 'inst_lokinst'], 'string', 'max' => 100],
            [['id_jabatan'], 'string', 'max' => 3]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was9' => 'Id Was9',
            'tanggal_was9' => 'Tanggal Was9',
            'perihal_was9' => 'Perihal Was9',
            'lampiran_was9' => 'Lampiran Was9',
            'id_saksi_was9' => 'Id Saksi Was9',
            'no_register' => 'No Register',
            'jenis_saksi' => 'Jenis Saksi',
            'nip' => 'Nip',
            'hari_pemeriksaan_was9' => 'Hari Pemeriksaan Was9',
            'tanggal_pemeriksaan_was9' => 'Tanggal Pemeriksaan Was9',
            'jam_pemeriksaan_was9' => 'Jam Pemeriksaan Was9',
            'tempat_pemeriksaan_was9' => 'Tempat Pemeriksaan Was9',
            'nip_penandatangan' => 'Nip Penandatangan',
            'nama_penandatangan' => 'Nama Penandatangan',
            'pangkat_penandatangan' => 'Pangkat Penandatangan',
            'golongan_penandatangan' => 'Golongan Penandatangan',
            'jabatan_penandatangan' => 'Jabatan Penandatangan',
            'was9_file' => 'Was9 File',
            'id_sp_was' => 'Id Sp Was',
            'sifat_was9' => 'Sifat Was9',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'nomor_surat_was9' => 'Nomor Surat Was9',
            'inst_satkerkd' => 'Inst Satkerkd',
            'zona' => 'Zona',
            'inst_nama' => 'Inst Nama',
            'inst_lokinst' => 'Inst Lokinst',
            'id_jabatan' => 'Id Jabatan',
        ];
    }

    /**
     * @inheritdoc
     * @return Query the active query used by this AR class.
     */
 
}
