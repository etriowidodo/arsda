<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.sp_surat_menyurat".
 *
 * @property string $no_surat
 * @property string $lapdu_id
 * @property string $dokumen_kd
 * @property string $dari_nik
 * @property string $dari_gol
 * @property string $dari_nip
 * @property string $dari_nrp
 * @property string $dari_pangkat
 * @property integer $dari_jabatan
 * @property string $dari_nama
 * @property string $dari_inst
 * @property string $dari_unitkerja
 * @property string $dari_tanggal
 * @property string $dikeluarkan_di
 * @property string $perihal
 * @property string $sifat
 * @property string $lampiran
 * @property string $kepada_nama
 * @property string $kepada_nik
 * @property string $kepada_gol
 * @property string $kepada_pangkat
 * @property integer $kepada_jabatan
 * @property string $kepada_inst
 * @property string $kepada_unitkerja
 * @property string $kepada_tanggal
 * @property string $kepada_tempat
 * @property string $dasar_hukum
 * @property string $pertimbangan
 * @property string $nik_pengesah
 * @property string $jns_inspeksi
 * @property integer $jabatan_pengesah
 * @property string $inst_bbnanggaran
 * @property integer $jns_instansi
 * @property string $jns_pemeriksaan
 * @property string $tembusan
 * @property string $kepada_tgl_akhir
 * @property string $nodis_disposisi
 * @property string $tgl_nodis_disposisi
 * @property string $id_cabang
 * @property integer $is_deleted
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class SpSuratMenyurat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.sp_surat_menyurat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dari_jabatan', 'kepada_jabatan', 'jabatan_pengesah', 'jns_instansi', 'is_deleted', 'createdby', 'updatedby'], 'integer'],
            [['dari_tanggal', 'kepada_tanggal', 'kepada_tgl_akhir', 'tgl_nodis_disposisi', 'createdtime', 'updatedtime'], 'safe'],
            [['no_surat'], 'string', 'max' => 35],
            [['lapdu_id'], 'string', 'max' => 15],
            [['dokumen_kd', 'dari_nik', 'dari_nip', 'kepada_nik', 'nik_pengesah'], 'string', 'max' => 20],
            [['dari_gol', 'kepada_gol'], 'string', 'max' => 5],
            [['dari_nrp'], 'string', 'max' => 10],
            [['dari_pangkat', 'dari_nama', 'sifat', 'kepada_nama', 'kepada_pangkat', 'nodis_disposisi'], 'string', 'max' => 50],
            [['dari_inst', 'dari_unitkerja', 'kepada_inst', 'kepada_unitkerja', 'inst_bbnanggaran'], 'string', 'max' => 12],
            [['dikeluarkan_di', 'kepada_tempat'], 'string', 'max' => 60],
            [['perihal'], 'string', 'max' => 200],
            [['lampiran'], 'string', 'max' => 2000],
            [['dasar_hukum', 'pertimbangan'], 'string', 'max' => 4000],
            [['jns_inspeksi'], 'string', 'max' => 1],
            [['jns_pemeriksaan'], 'string', 'max' => 18],
            [['tembusan'], 'string', 'max' => 1000],
            [['id_cabang'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_surat' => 'No Surat',
            'lapdu_id' => 'Lapdu ID',
            'dokumen_kd' => 'Dokumen Kd',
            'dari_nik' => 'Dari Nik',
            'dari_gol' => 'Dari Gol',
            'dari_nip' => 'Dari Nip',
            'dari_nrp' => 'Dari Nrp',
            'dari_pangkat' => 'Dari Pangkat',
            'dari_jabatan' => 'Dari Jabatan',
            'dari_nama' => 'Dari Nama',
            'dari_inst' => 'Dari Inst',
            'dari_unitkerja' => 'Dari Unitkerja',
            'dari_tanggal' => 'Dari Tanggal',
            'dikeluarkan_di' => 'Dikeluarkan Di',
            'perihal' => 'Perihal',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
            'kepada_nama' => 'Kepada Nama',
            'kepada_nik' => 'Kepada Nik',
            'kepada_gol' => 'Kepada Gol',
            'kepada_pangkat' => 'Kepada Pangkat',
            'kepada_jabatan' => 'Kepada Jabatan',
            'kepada_inst' => 'Kepada Inst',
            'kepada_unitkerja' => 'Kepada Unitkerja',
            'kepada_tanggal' => 'Kepada Tanggal',
            'kepada_tempat' => 'Kepada Tempat',
            'dasar_hukum' => 'Dasar Hukum',
            'pertimbangan' => 'Pertimbangan',
            'nik_pengesah' => 'Nik Pengesah',
            'jns_inspeksi' => 'Jns Inspeksi',
            'jabatan_pengesah' => 'Jabatan Pengesah',
            'inst_bbnanggaran' => 'Inst Bbnanggaran',
            'jns_instansi' => 'Jns Instansi',
            'jns_pemeriksaan' => 'Jns Pemeriksaan',
            'tembusan' => 'Tembusan',
            'kepada_tgl_akhir' => 'Kepada Tgl Akhir',
            'nodis_disposisi' => 'Nodis Disposisi',
            'tgl_nodis_disposisi' => 'Tgl Nodis Disposisi',
            'id_cabang' => 'Id Cabang',
            'is_deleted' => 'Is Deleted',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
