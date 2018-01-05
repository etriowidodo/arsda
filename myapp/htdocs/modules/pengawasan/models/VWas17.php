<?php

namespace app\modules\pengawasan\models;

use Yii;

/**
 * This is the model class for table "was.v_was_17".
 *
 * @property string $id_was_17
 * @property string $no_was_17
 * @property string $id_register
 * @property string $inst_satkerkd
 * @property integer $kpd_was_17
 * @property string $id_terlapor
 * @property string $tgl_was_17
 * @property integer $sifat_surat
 * @property integer $jml_lampiran
 * @property integer $satuan_lampiran
 * @property integer $ttd_was_17
 * @property string $ttd_peg_nik
 * @property integer $ttd_id_jabatan
 * @property string $upload_file
 * @property string $perihal
 * @property string $tempat
 * @property string $kejaksaan
 * @property string $kpd
 * @property string $sifat
 * @property string $dari
 * @property string $nip
 * @property string $nrp_terlapor
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
class VWas17 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.v_was_17';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kpd_was_17', 'sifat_surat', 'jml_lampiran', 'satuan_lampiran', 'ttd_was_17', 'ttd_id_jabatan'], 'integer'],
            [['tgl_was_17', 'tanggal_surat_dinas'], 'safe'],
            [['jabatan', 'ttd_jabatan'], 'string'],
            [['id_was_17', 'id_register', 'id_terlapor'], 'string', 'max' => 16],
            [['no_was_17', 'ttd_peg_nik', 'nip', 'ttd_peg_nip', 'no_surat_dinas'], 'string', 'max' => 20],
            [['inst_satkerkd'], 'string', 'max' => 10],
            [['upload_file', 'kpd', 'dari', 'dugaan_pelanggaran'], 'string', 'max' => 200],
            [['perihal'], 'string', 'max' => 1000],
            [['tempat', 'kejaksaan', 'aturan_hukum'], 'string', 'max' => 100],
            [['sifat'], 'string', 'max' => 225],
            [['nrp_terlapor'], 'string', 'max' => 12],
            [['nama', 'ttd_peg_nama'], 'string', 'max' => 65],
            [['keterangan'], 'string', 'max' => 60],
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
            'id_was_17' => 'Id Was 17',
            'no_was_17' => 'No Was 17',
            'id_register' => 'Id Register',
            'inst_satkerkd' => 'Inst Satkerkd',
            'kpd_was_17' => 'Kpd Was 17',
            'id_terlapor' => 'Id Terlapor',
            'tgl_was_17' => 'Tgl Was 17',
            'sifat_surat' => 'Sifat Surat',
            'jml_lampiran' => 'Jml Lampiran',
            'satuan_lampiran' => 'Satuan Lampiran',
            'ttd_was_17' => 'Ttd Was 17',
            'ttd_peg_nik' => 'Ttd Peg Nik',
            'ttd_id_jabatan' => 'Ttd Id Jabatan',
            'upload_file' => 'Upload File',
            'perihal' => 'Perihal',
            'tempat' => 'Tempat',
            'kejaksaan' => 'Kejaksaan',
            'kpd' => 'Kpd',
            'sifat' => 'Sifat',
            'dari' => 'Dari',
            'nip' => 'Nip',
            'nrp_terlapor' => 'Nrp Terlapor',
            'nama' => 'Nama',
            'jabatan' => 'Jabatan',
            'ttd_jabatan' => 'Ttd Jabatan',
            'ttd_peg_nama' => 'Ttd Peg Nama',
            'ttd_peg_nip' => 'Ttd Peg Nip',
            'no_surat_dinas' => 'No Surat Dinas',
            'tanggal_surat_dinas' => 'Tanggal Surat Dinas',
            'dugaan_pelanggaran' => 'Dugaan Pelanggaran',
            'keterangan' => 'Keterangan',
            'aturan_hukum' => 'Aturan Hukum',
            'pasal' => 'Pasal',
            'ayat' => 'Ayat',
            'bentuk_hukuman' => 'Bentuk Hukuman',
            'huruf' => 'Huruf',
        ];
    }
}
