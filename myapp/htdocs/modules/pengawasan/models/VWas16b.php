<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_was_16b".
 *
 * @property string $id_was_16b
 * @property string $no_was_16b
 * @property string $id_register
 * @property string $inst_satkerkd
 * @property integer $kpd_was_16b
 * @property string $id_terlapor
 * @property string $tgl_was_16b
 * @property integer $sifat_surat
 * @property integer $jml_lampiran
 * @property integer $satuan_lampiran
 * @property string $perihal
 * @property integer $ttd_was_16b
 * @property string $ttd_peg_nik
 * @property string $ttd_id_jabatan
 * @property string $upload_file
 * @property string $flag
 * @property integer $created_by
 * @property string $created_ip
 * @property string $created_time
 * @property string $updated_ip
 * @property integer $updated_by
 * @property string $updated_time
 * @property string $tempat
 * @property string $kejaksaan
 * @property string $kpd
 * @property string $sifat
 * @property string $dari
 * @property string $nip
 * @property string $nama
 * @property string $jabatan
 * @property string $ttd_jabatan
 * @property string $ttd_peg_nama
 * @property string $ttd_peg_nip
 * @property string $no_surat_dinas
 * @property string $tanggal_surat_dinas
 * @property string $dugaan_pelanggaran
 * @property string $keterangan
 * @property string $aturan_hukum
 * @property string $pasal
 * @property string $ayat
 * @property string $bentuk_hukuman
 * @property string $huruf
 */
class VWas16b extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_was_16b';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kpd_was_16b', 'sifat_surat', 'jml_lampiran', 'satuan_lampiran', 'ttd_was_16b', 'created_by', 'updated_by'], 'integer'],
            [['tgl_was_16b', 'created_time', 'updated_time', 'tanggal_surat_dinas'], 'safe'],
            [['jabatan', 'ttd_jabatan'], 'string'],
            [['id_was_16b', 'id_register', 'id_terlapor', 'ttd_id_jabatan'], 'string', 'max' => 16],
            [['no_was_16b', 'ttd_peg_nik', 'nip', 'ttd_peg_nip', 'no_surat_dinas'], 'string', 'max' => 20],
            [['inst_satkerkd'], 'string', 'max' => 10],
            [['perihal'], 'string', 'max' => 1000],
            [['upload_file', 'kpd', 'dari', 'dugaan_pelanggaran'], 'string', 'max' => 200],
            [['flag'], 'string', 'max' => 1],
            [['created_ip', 'updated_ip'], 'string', 'max' => 15],
            [['tempat', 'kejaksaan', 'aturan_hukum'], 'string', 'max' => 100],
            [['sifat'], 'string', 'max' => 225],
            [['nama', 'ttd_peg_nama'], 'string', 'max' => 65],
            //[['keterangan'], 'string', 'max' => 60],
            [['pasal', 'ayat'], 'string', 'max' => 5],
            [['bentuk_hukuman'], 'string', 'max' => 2000],
            [['huruf'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_was_16b' => 'Id Was 16b',
            'no_was_16b' => 'No Was 16b',
            'id_register' => 'Id Register',
            'inst_satkerkd' => 'Inst Satkerkd',
            'kpd_was_16b' => 'Kpd Was 16b',
            'id_terlapor' => 'Id Terlapor',
            'tgl_was_16b' => 'Tgl Was 16b',
            'sifat_surat' => 'Sifat Surat',
            'jml_lampiran' => 'Jml Lampiran',
            'satuan_lampiran' => 'Satuan Lampiran',
            'perihal' => 'Perihal',
            'ttd_was_16b' => 'Ttd Was 16b',
            'ttd_peg_nik' => 'Ttd Peg Nik',
            'ttd_id_jabatan' => 'Ttd Id Jabatan',
            'upload_file' => 'Upload File',
            'flag' => 'Flag',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'created_time' => 'Created Time',
            'updated_ip' => 'Updated Ip',
            'updated_by' => 'Updated By',
            'updated_time' => 'Updated Time',
            'tempat' => 'Tempat',
            'kejaksaan' => 'Kejaksaan',
            'kpd' => 'Kpd',
            'sifat' => 'Sifat',
            'dari' => 'Dari',
            'nip' => 'Nip',
            'nama' => 'Nama',
            'jabatan' => 'Jabatan',
            'ttd_jabatan' => 'Ttd Jabatan',
            'ttd_peg_nama' => 'Ttd Peg Nama',
            'ttd_peg_nip' => 'Ttd Peg Nip',
            'no_surat_dinas' => 'No Surat Dinas',
            'tanggal_surat_dinas' => 'Tanggal Surat Dinas',
            'dugaan_pelanggaran' => 'Dugaan Pelanggaran',
           // 'keterangan' => 'Keterangan',
            'aturan_hukum' => 'Aturan Hukum',
            'pasal' => 'Pasal',
            'ayat' => 'Ayat',
            'bentuk_hukuman' => 'Bentuk Hukuman',
            'huruf' => 'Huruf',
        ];
    }
}
