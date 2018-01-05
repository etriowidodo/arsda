<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "was.sp_lapdu".
 *
 * @property string $lapdu_id
 * @property string $tgl_penerimaan
 * @property integer $jns_terbitanlapdu
 * @property string $inst_lapdu
 * @property string $sumber_lapdu
 * @property string $pel_namasumber
 * @property string $unitkerja_lapdu
 * @property string $pel_tempat
 * @property string $pel_tanggal
 * @property string $pel_nosurat
 * @property string $pel_tglsurat
 * @property string $pel_perihalsurat
 * @property string $pel_tujuansrt
 * @property integer $jml_terlapor
 * @property string $terl_nik
 * @property string $terl_pangkat
 * @property string $terl_nip
 * @property string $terl_nrp
 * @property string $terl_jabatan
 * @property string $terl_instsatker
 * @property string $terl_nama
 * @property string $terl_unitkerja
 * @property string $telp_jbtprof
 * @property string $uraian_perbuatan
 * @property string $tgl_telaahan1
 * @property string $prs_penanganan
 * @property string $tgl_disp_jamwas
 * @property string $srt_jamwasno
 * @property string $srtp_jamwastgl
 * @property string $plhp_no
 * @property string $plhp_tgl
 * @property string $tgl_telaahan2
 * @property string $pp_jamwasno
 * @property string $pp_jamwastgl
 * @property string $pp_tujuan
 * @property string $nd_jamwasphd
 * @property string $nd_jamwasphdtgl
 * @property string $nd_tujuan
 * @property string $phd_no
 * @property string $phd_tgl
 * @property string $pk_kajatino
 * @property string $pk_kajatitgl
 * @property integer $level_phd
 * @property string $pejabat_phd
 * @property string $sk_tgl
 * @property string $sk_no
 * @property string $pasal_sangkaan
 * @property integer $pasal_deskripsi
 * @property integer $jenis_hukuman
 * @property string $jenis_perbuatan
 * @property string $keterangan
 * @property integer $sts_pmasyarakat
 * @property integer $sts_penanganan
 * @property integer $sts_keputusan
 * @property integer $sts_selesai
 * @property string $tgl_selesai
 * @property integer $jns_inspeksi
 * @property integer $jns_instansi
 * @property string $pel_tembusan
 * @property integer $peraturan_id
 * @property string $pasal_dilanggar
 * @property integer $sts_akhir
 * @property string $bentuk_hukuman
 * @property string $id_cabang
 * @property integer $is_deleted
 * @property integer $createdby
 * @property string $createdtime
 * @property integer $updatedby
 * @property string $updatedtime
 */
class SpLapdu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'was.sp_lapdu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_penerimaan', 'pel_tanggal', 'pel_tglsurat', 'tgl_telaahan1', 'tgl_disp_jamwas', 'srtp_jamwastgl', 'plhp_tgl', 'tgl_telaahan2', 'pp_jamwastgl', 'nd_jamwasphdtgl', 'phd_tgl', 'pk_kajatitgl', 'sk_tgl', 'tgl_selesai', 'createdtime', 'updatedtime'], 'safe'],
            [['jns_terbitanlapdu', 'jml_terlapor', 'level_phd', 'pasal_deskripsi', 'jenis_hukuman', 'sts_pmasyarakat', 'sts_penanganan', 'sts_keputusan', 'sts_selesai', 'jns_inspeksi', 'jns_instansi', 'peraturan_id', 'sts_akhir', 'is_deleted', 'createdby', 'updatedby'], 'integer'],
            [['lapdu_id'], 'string', 'max' => 15],
            [['inst_lapdu', 'unitkerja_lapdu', 'terl_nik', 'terl_nip', 'terl_jabatan', 'terl_unitkerja', 'telp_jbtprof'], 'string', 'max' => 20],
            [['sumber_lapdu', 'terl_pangkat', 'prs_penanganan', 'pejabat_phd', 'pasal_sangkaan', 'pasal_dilanggar', 'id_cabang'], 'string', 'max' => 100],
            [['pel_namasumber'], 'string', 'max' => 150],
            [['pel_tempat'], 'string', 'max' => 80],
            [['pel_nosurat', 'srt_jamwasno', 'plhp_no', 'pp_jamwasno', 'nd_jamwasphd', 'phd_no', 'pk_kajatino', 'sk_no'], 'string', 'max' => 35],
            [['pel_perihalsurat', 'bentuk_hukuman'], 'string', 'max' => 300],
            [['pel_tujuansrt', 'pp_tujuan', 'nd_tujuan'], 'string', 'max' => 200],
            [['terl_nrp'], 'string', 'max' => 10],
            [['terl_instsatker'], 'string', 'max' => 12],
            [['terl_nama'], 'string', 'max' => 60],
            [['uraian_perbuatan', 'pel_tembusan'], 'string', 'max' => 1000],
            [['jenis_perbuatan'], 'string', 'max' => 3],
            [['keterangan'], 'string', 'max' => 400]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lapdu_id' => 'Lapdu ID',
            'tgl_penerimaan' => 'Tgl Penerimaan',
            'jns_terbitanlapdu' => 'Jns Terbitanlapdu',
            'inst_lapdu' => 'Inst Lapdu',
            'sumber_lapdu' => 'Sumber Lapdu',
            'pel_namasumber' => 'Pel Namasumber',
            'unitkerja_lapdu' => 'Unitkerja Lapdu',
            'pel_tempat' => 'Pel Tempat',
            'pel_tanggal' => 'Pel Tanggal',
            'pel_nosurat' => 'Pel Nosurat',
            'pel_tglsurat' => 'Pel Tglsurat',
            'pel_perihalsurat' => 'Pel Perihalsurat',
            'pel_tujuansrt' => 'Pel Tujuansrt',
            'jml_terlapor' => 'Jml Terlapor',
            'terl_nik' => 'Terl Nik',
            'terl_pangkat' => 'Terl Pangkat',
            'terl_nip' => 'Terl Nip',
            'terl_nrp' => 'Terl Nrp',
            'terl_jabatan' => 'Terl Jabatan',
            'terl_instsatker' => 'Terl Instsatker',
            'terl_nama' => 'Terl Nama',
            'terl_unitkerja' => 'Terl Unitkerja',
            'telp_jbtprof' => 'Telp Jbtprof',
            'uraian_perbuatan' => 'Uraian Perbuatan',
            'tgl_telaahan1' => 'Tgl Telaahan1',
            'prs_penanganan' => 'Prs Penanganan',
            'tgl_disp_jamwas' => 'Tgl Disp Jamwas',
            'srt_jamwasno' => 'Srt Jamwasno',
            'srtp_jamwastgl' => 'Srtp Jamwastgl',
            'plhp_no' => 'Plhp No',
            'plhp_tgl' => 'Plhp Tgl',
            'tgl_telaahan2' => 'Tgl Telaahan2',
            'pp_jamwasno' => 'Pp Jamwasno',
            'pp_jamwastgl' => 'Pp Jamwastgl',
            'pp_tujuan' => 'Pp Tujuan',
            'nd_jamwasphd' => 'Nd Jamwasphd',
            'nd_jamwasphdtgl' => 'Nd Jamwasphdtgl',
            'nd_tujuan' => 'Nd Tujuan',
            'phd_no' => 'Phd No',
            'phd_tgl' => 'Phd Tgl',
            'pk_kajatino' => 'Pk Kajatino',
            'pk_kajatitgl' => 'Pk Kajatitgl',
            'level_phd' => 'Level Phd',
            'pejabat_phd' => 'Pejabat Phd',
            'sk_tgl' => 'Sk Tgl',
            'sk_no' => 'Sk No',
            'pasal_sangkaan' => 'Pasal Sangkaan',
            'pasal_deskripsi' => 'Pasal Deskripsi',
            'jenis_hukuman' => 'Jenis Hukuman',
            'jenis_perbuatan' => 'Jenis Perbuatan',
            'keterangan' => 'Keterangan',
            'sts_pmasyarakat' => 'Sts Pmasyarakat',
            'sts_penanganan' => 'Sts Penanganan',
            'sts_keputusan' => 'Sts Keputusan',
            'sts_selesai' => 'Sts Selesai',
            'tgl_selesai' => 'Tgl Selesai',
            'jns_inspeksi' => 'Jns Inspeksi',
            'jns_instansi' => 'Jns Instansi',
            'pel_tembusan' => 'Pel Tembusan',
            'peraturan_id' => 'Peraturan ID',
            'pasal_dilanggar' => 'Pasal Dilanggar',
            'sts_akhir' => 'Sts Akhir',
            'bentuk_hukuman' => 'Bentuk Hukuman',
            'id_cabang' => 'Id Cabang',
            'is_deleted' => 'Is Deleted',
            'createdby' => 'Createdby',
            'createdtime' => 'Createdtime',
            'updatedby' => 'Updatedby',
            'updatedtime' => 'Updatedtime',
        ];
    }
}
