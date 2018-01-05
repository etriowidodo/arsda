<?php

namespace app\modules\security\models;

use Yii;

/**
 * This is the model class for table "kepegawaian.kp_pegawai".
 *
 * @property integer $is_verified
 * @property string $peg_foto_baru
 * @property integer $peg_jnspeg
 * @property string $tanggal_lp2p
 * @property string $tanggal_lkpn
 * @property string $cpns_tmt
 * @property string $pns_tmt
 * @property string $peg_karpegno
 * @property string $peg_nik
 * @property string $peg_nip
 * @property string $peg_nrp
 * @property string $peg_nip_baru
 * @property string $nip_nrp
 * @property string $nama
 * @property string $peg_jender
 * @property string $peg_agama
 * @property string $tlahir
 * @property string $peg_tgllahir
 * @property integer $usia
 * @property string $peg_gelar
 * @property integer $jabat_jenisjabatan
 * @property string $jaksa_tmt
 * @property string $jabatan
 * @property string $ref_jabatan_desc_singkat
 * @property integer $ref_jabatan_kd
 * @property string $jabat_nosk
 * @property string $jabat_tglsk
 * @property string $jabatan_panjang
 * @property string $unitkerja_kd
 * @property string $unitkerja_idk
 * @property string $unitkerja_nama
 * @property integer $kode_jabatan
 * @property integer $is_verified_jabatan
 * @property string $jabat_tmt
 * @property integer $peg_golakhir_mkth
 * @property string $eselon
 * @property integer $jenjang
 * @property string $di_level
 * @property string $inst_satkerkd
 * @property string $is_active_satker
 * @property string $instansi
 * @property string $jabat_unitkerja
 * @property string $kelas_jabatan
 * @property string $gol_kd
 * @property string $gol_pangkat
 * @property string $gol_pangkat2
 * @property integer $gol_mk_thn
 * @property integer $gol_mk_bln
 * @property integer $pns_jnsjbtfungsi
 * @property string $peg_jbtakhirfs
 * @property integer $peg_jbtakhirstk
 * @property integer $peg_stsmarital
 * @property string $marital
 * @property string $peg_alamat
 * @property string $peg_almtposkd
 * @property string $gol_pangkatjaksa
 * @property string $gol_tmt
 * @property integer $is_verified_golongan
 * @property integer $pns_kddkn_hkm
 * @property string $peg_pddkn_fml
 * @property integer $is_verified_peg_pddkn_fml
 * @property string $diklat_struktur
 * @property integer $is_verified_diklat_struktur
 * @property string $pendidikan
 * @property string $pendidikan_panjang
 * @property string $spend_akronim
 * @property string $pend_tahunlulus
 * @property string $pend_namagelar
 * @property string $status
 * @property string $jenisjabatan
 * @property integer $jabat_mk_th
 * @property integer $jabat_mk_bln
 * @property integer $cpns_mk_th
 * @property integer $cpns_mk_bln
 * @property string $masuk_masa_pensiun
 * @property string $no_askes
 * @property string $pns_tgldisumpah
 * @property integer $jumlah_keluarga
 * @property string $gaji_tmt
 * @property string $kgb_tmt_yad
 * @property string $max_gaji_tmt
 * @property integer $kgb_gapok
 * @property string $jabat_angkakredit
 * @property string $lon
 * @property string $lat
 * @property string $peg_instakhir_uk
 * @property string $peg_instakhir
 * @property string $gol_pangkat_jaksa_tu
 * @property string $gol_status_jaksa_tu
 * @property string $pangkat_gol_jaksa_tu
 */
class KpPegawai extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kepegawaian.kp_pegawai';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_verified', 'peg_jnspeg', 'usia', 'jabat_jenisjabatan', 'ref_jabatan_kd', 'kode_jabatan', 'is_verified_jabatan', 'peg_golakhir_mkth', 'jenjang', 'gol_mk_thn', 'gol_mk_bln', 'pns_jnsjbtfungsi', 'peg_jbtakhirstk', 'peg_stsmarital', 'is_verified_golongan', 'pns_kddkn_hkm', 'is_verified_peg_pddkn_fml', 'is_verified_diklat_struktur', 'jabat_mk_th', 'jabat_mk_bln', 'cpns_mk_th', 'cpns_mk_bln', 'jumlah_keluarga', 'kgb_gapok'], 'integer'],
            [['tanggal_lp2p', 'tanggal_lkpn', 'cpns_tmt', 'pns_tmt', 'jabat_tglsk', 'jabat_tmt', 'gol_tmt', 'pend_tahunlulus', 'pns_tgldisumpah'], 'safe'],
            [['peg_nip', 'peg_nip_baru'], 'required'],
            [['jabat_angkakredit'], 'number'],
            [['peg_foto_baru', 'tlahir', 'jabatan', 'ref_jabatan_desc_singkat', 'peg_alamat', 'pendidikan_panjang'], 'string', 'max' => 200],
            [['peg_karpegno', 'peg_nik', 'peg_nip', 'peg_nrp', 'peg_nip_baru', 'peg_agama', 'peg_tgllahir', 'peg_gelar', 'unitkerja_kd', 'unitkerja_idk', 'eselon', 'di_level', 'inst_satkerkd', 'is_active_satker', 'jabat_unitkerja', 'kelas_jabatan', 'gol_kd', 'peg_jbtakhirfs', 'marital', 'peg_almtposkd', 'peg_pddkn_fml', 'spend_akronim', 'pend_namagelar', 'status', 'jenisjabatan', 'masuk_masa_pensiun', 'lon', 'lat'], 'string', 'max' => 30],
            [['nip_nrp', 'gol_pangkat', 'gol_pangkat2', 'gol_pangkatjaksa', 'peg_instakhir_uk'], 'string', 'max' => 50],
            [['nama', 'diklat_struktur'], 'string', 'max' => 80],
            [['peg_jender'], 'string', 'max' => 5],
            [['jaksa_tmt', 'gaji_tmt', 'kgb_tmt_yad', 'max_gaji_tmt'], 'string', 'max' => 10],
            [['jabat_nosk', 'unitkerja_nama', 'instansi', 'pendidikan', 'no_askes'], 'string', 'max' => 100],
            [['jabatan_panjang'], 'string', 'max' => 300],
            [['peg_instakhir'], 'string', 'max' => 12],
            [['gol_pangkat_jaksa_tu'], 'string', 'max' => 25],
            [['gol_status_jaksa_tu'], 'string', 'max' => 1],
            [['pangkat_gol_jaksa_tu'], 'string', 'max' => 33]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'is_verified' => 'Is Verified',
            'peg_foto_baru' => 'Peg Foto Baru',
            'peg_jnspeg' => 'Peg Jnspeg',
            'tanggal_lp2p' => 'Tanggal Lp2p',
            'tanggal_lkpn' => 'Tanggal Lkpn',
            'cpns_tmt' => 'Cpns Tmt',
            'pns_tmt' => 'Pns Tmt',
            'peg_karpegno' => 'Peg Karpegno',
            'peg_nik' => 'Peg Nik',
            'peg_nip' => 'Peg Nip',
            'peg_nrp' => 'Peg Nrp',
            'peg_nip_baru' => 'Peg Nip Baru',
            'nip_nrp' => 'Nip Nrp',
            'nama' => 'Nama',
            'peg_jender' => 'Peg Jender',
            'peg_agama' => 'Peg Agama',
            'tlahir' => 'Tlahir',
            'peg_tgllahir' => 'Peg Tgllahir',
            'usia' => 'Usia',
            'peg_gelar' => 'Peg Gelar',
            'jabat_jenisjabatan' => 'Jabat Jenisjabatan',
            'jaksa_tmt' => 'Jaksa Tmt',
            'jabatan' => 'Jabatan',
            'ref_jabatan_desc_singkat' => 'Ref Jabatan Desc Singkat',
            'ref_jabatan_kd' => 'Ref Jabatan Kd',
            'jabat_nosk' => 'Jabat Nosk',
            'jabat_tglsk' => 'Jabat Tglsk',
            'jabatan_panjang' => 'Jabatan Panjang',
            'unitkerja_kd' => 'Unitkerja Kd',
            'unitkerja_idk' => 'Unitkerja Idk',
            'unitkerja_nama' => 'Unitkerja Nama',
            'kode_jabatan' => 'Kode Jabatan',
            'is_verified_jabatan' => 'Is Verified Jabatan',
            'jabat_tmt' => 'Jabat Tmt',
            'peg_golakhir_mkth' => 'Peg Golakhir Mkth',
            'eselon' => 'Eselon',
            'jenjang' => 'Jenjang',
            'di_level' => 'Di Level',
            'inst_satkerkd' => 'Inst Satkerkd',
            'is_active_satker' => 'Is Active Satker',
            'instansi' => 'Instansi',
            'jabat_unitkerja' => 'Jabat Unitkerja',
            'kelas_jabatan' => 'Kelas Jabatan',
            'gol_kd' => 'Gol Kd',
            'gol_pangkat' => 'Gol Pangkat',
            'gol_pangkat2' => 'Gol Pangkat2',
            'gol_mk_thn' => 'Gol Mk Thn',
            'gol_mk_bln' => 'Gol Mk Bln',
            'pns_jnsjbtfungsi' => 'Pns Jnsjbtfungsi',
            'peg_jbtakhirfs' => 'Peg Jbtakhirfs',
            'peg_jbtakhirstk' => 'Peg Jbtakhirstk',
            'peg_stsmarital' => 'Peg Stsmarital',
            'marital' => 'Marital',
            'peg_alamat' => 'Peg Alamat',
            'peg_almtposkd' => 'Peg Almtposkd',
            'gol_pangkatjaksa' => 'Gol Pangkatjaksa',
            'gol_tmt' => 'Gol Tmt',
            'is_verified_golongan' => 'Is Verified Golongan',
            'pns_kddkn_hkm' => 'Pns Kddkn Hkm',
            'peg_pddkn_fml' => 'Peg Pddkn Fml',
            'is_verified_peg_pddkn_fml' => 'Is Verified Peg Pddkn Fml',
            'diklat_struktur' => 'Diklat Struktur',
            'is_verified_diklat_struktur' => 'Is Verified Diklat Struktur',
            'pendidikan' => 'Pendidikan',
            'pendidikan_panjang' => 'Pendidikan Panjang',
            'spend_akronim' => 'Spend Akronim',
            'pend_tahunlulus' => 'Pend Tahunlulus',
            'pend_namagelar' => 'Pend Namagelar',
            'status' => 'Status',
            'jenisjabatan' => 'Jenisjabatan',
            'jabat_mk_th' => 'Jabat Mk Th',
            'jabat_mk_bln' => 'Jabat Mk Bln',
            'cpns_mk_th' => 'Cpns Mk Th',
            'cpns_mk_bln' => 'Cpns Mk Bln',
            'masuk_masa_pensiun' => 'Masuk Masa Pensiun',
            'no_askes' => 'No Askes',
            'pns_tgldisumpah' => 'Pns Tgldisumpah',
            'jumlah_keluarga' => 'Jumlah Keluarga',
            'gaji_tmt' => 'Gaji Tmt',
            'kgb_tmt_yad' => 'Kgb Tmt Yad',
            'max_gaji_tmt' => 'Max Gaji Tmt',
            'kgb_gapok' => 'Kgb Gapok',
            'jabat_angkakredit' => 'Jabat Angkakredit',
            'lon' => 'Lon',
            'lat' => 'Lat',
            'peg_instakhir_uk' => 'Peg Instakhir Uk',
            'peg_instakhir' => 'Peg Instakhir',
            'gol_pangkat_jaksa_tu' => 'Gol Pangkat Jaksa Tu',
            'gol_status_jaksa_tu' => 'Gol Status Jaksa Tu',
            'pangkat_gol_jaksa_tu' => 'Pangkat Gol Jaksa Tu',
        ];
    }
}
