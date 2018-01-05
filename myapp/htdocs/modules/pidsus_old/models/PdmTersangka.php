<?php

namespace app\modules\pidsus\models;

use Yii;

/**
 * This is the model class for table "simkari.pdm_tersangka".
 *
 * @property integer $id
 * @property string $no_p16
 * @property string $nama
 * @property string $tempat_lahir
 * @property string $tgl_lahir
 * @property string $jkl
 * @property string $kewarganegaraan
 * @property string $alamat
 * @property string $pekerjaan
 * @property string $id_agama
 * @property string $pendidikan
 * @property string $ph_jpu_mulai
 * @property string $ph_jpu_selesai
 * @property string $ph_jpu_lokasi
 * @property string $ph_hakim1_mulai
 * @property string $ph_hakim1_selesai
 * @property string $ph_hakim1_lokasi
 * @property string $ph_hakim2_mulai
 * @property string $ph_hakim2_selesai
 * @property string $ph_hakim2_lokasi
 * @property string $ph_pengalihan_mulai
 * @property string $ph_pengalihan_selesai
 * @property string $ph_pengalihan_lokasi
 * @property string $ph_pembantaran_mulai
 * @property string $ph_pembantaran_selesai
 * @property string $ph_pembantaran_lokasi
 * @property string $jenis_putusan
 * @property string $pj_pidana_coba
 * @property string $pj_masa_coba
 * @property string $pj_badan_tahun
 * @property string $pj_badan_bulan
 * @property string $pj_badan_hari
 * @property string $pj_denda_rp
 * @property string $pj_sub_tahun
 * @property string $pj_sub_bulan
 * @property string $pj_sub_hari
 * @property string $pj_biaya
 * @property string $kurungan_tahun
 * @property string $kurungan_bulan
 * @property string $kurungan_hari
 * @property string $denda
 * @property string $putusan_tambahan
 * @property string $sikap_jaksa
 * @property string $sikap_terdakwa
 * @property string $ph_penyidik_mulai
 * @property string $ph_penyidik_selesai
 * @property string $ph_penyidik_lokasi
 * @property string $ph_kejari_mulai
 * @property string $ph_kejari_selesai
 * @property string $ph_kejari_lokasi
 * @property string $ph_pn_mulai
 * @property string $ph_pn_selesai
 * @property string $ph_pn_lokasi
 * @property string $umur
 * @property string $putusan_tetap
 * @property string $tgl_eksekusi
 * @property string $putusan_upaya_hukum
 * @property string $tgl_ptsn_bndg_ksasi
 * @property string $tgl_ptsn_pk_grasi
 * @property string $tgl_eksekusi_pk_grasi
 * @property string $pj_pidana_coba_thn
 * @property string $pj_pidana_coba_bln
 * @property string $pj_pidana_coba_hari
 *
 * @property P16 $noP16
 */
class PdmTersangka extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'simkari.pdm_tersangka';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_lahir', 'ph_jpu_mulai', 'ph_jpu_selesai', 'ph_hakim1_mulai', 'ph_hakim1_selesai', 'ph_hakim2_mulai', 'ph_hakim2_selesai', 'ph_pengalihan_mulai', 'ph_pengalihan_selesai', 'ph_pembantaran_mulai', 'ph_pembantaran_selesai', 'ph_penyidik_mulai', 'ph_penyidik_selesai', 'ph_kejari_mulai', 'ph_kejari_selesai', 'ph_pn_mulai', 'ph_pn_selesai', 'tgl_eksekusi', 'tgl_ptsn_bndg_ksasi', 'tgl_ptsn_pk_grasi', 'tgl_eksekusi_pk_grasi'], 'safe'],
            [['pj_badan_tahun', 'pj_badan_bulan', 'pj_badan_hari', 'pj_denda_rp', 'pj_sub_tahun', 'pj_sub_bulan', 'pj_sub_hari', 'pj_biaya', 'kurungan_tahun', 'kurungan_bulan', 'kurungan_hari', 'denda', 'umur', 'pj_pidana_coba_thn', 'pj_pidana_coba_bln', 'pj_pidana_coba_hari'], 'number'],
            [['no_p16', 'tempat_lahir', 'kewarganegaraan', 'ph_jpu_lokasi', 'ph_hakim1_lokasi', 'ph_hakim2_lokasi', 'ph_pengalihan_lokasi'], 'string', 'max' => 30],
            [['nama', 'pendidikan', 'ph_pembantaran_lokasi', 'ph_penyidik_lokasi', 'ph_kejari_lokasi', 'ph_pn_lokasi'], 'string', 'max' => 50],
            [['jkl', 'id_agama', 'jenis_putusan', 'sikap_jaksa', 'sikap_terdakwa', 'putusan_tetap', 'putusan_upaya_hukum'], 'string', 'max' => 1],
            [['alamat'], 'string', 'max' => 200],
            [['pekerjaan'], 'string', 'max' => 100],
            [['pj_pidana_coba', 'pj_masa_coba'], 'string', 'max' => 20],
            [['putusan_tambahan'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_p16' => 'No P16',
            'nama' => 'Nama',
            'tempat_lahir' => 'Tempat Lahir',
            'tgl_lahir' => 'Tgl Lahir',
            'jkl' => 'Jkl',
            'kewarganegaraan' => 'Kewarganegaraan',
            'alamat' => 'Alamat',
            'pekerjaan' => 'Pekerjaan',
            'id_agama' => 'Id Agama',
            'pendidikan' => 'Pendidikan',
            'ph_jpu_mulai' => 'Ph Jpu Mulai',
            'ph_jpu_selesai' => 'Ph Jpu Selesai',
            'ph_jpu_lokasi' => 'Ph Jpu Lokasi',
            'ph_hakim1_mulai' => 'Ph Hakim1 Mulai',
            'ph_hakim1_selesai' => 'Ph Hakim1 Selesai',
            'ph_hakim1_lokasi' => 'Ph Hakim1 Lokasi',
            'ph_hakim2_mulai' => 'Ph Hakim2 Mulai',
            'ph_hakim2_selesai' => 'Ph Hakim2 Selesai',
            'ph_hakim2_lokasi' => 'Ph Hakim2 Lokasi',
            'ph_pengalihan_mulai' => 'Ph Pengalihan Mulai',
            'ph_pengalihan_selesai' => 'Ph Pengalihan Selesai',
            'ph_pengalihan_lokasi' => 'Ph Pengalihan Lokasi',
            'ph_pembantaran_mulai' => 'Ph Pembantaran Mulai',
            'ph_pembantaran_selesai' => 'Ph Pembantaran Selesai',
            'ph_pembantaran_lokasi' => 'Ph Pembantaran Lokasi',
            'jenis_putusan' => 'Jenis Putusan',
            'pj_pidana_coba' => 'Pj Pidana Coba',
            'pj_masa_coba' => 'Pj Masa Coba',
            'pj_badan_tahun' => 'Pj Badan Tahun',
            'pj_badan_bulan' => 'Pj Badan Bulan',
            'pj_badan_hari' => 'Pj Badan Hari',
            'pj_denda_rp' => 'Pj Denda Rp',
            'pj_sub_tahun' => 'Pj Sub Tahun',
            'pj_sub_bulan' => 'Pj Sub Bulan',
            'pj_sub_hari' => 'Pj Sub Hari',
            'pj_biaya' => 'Pj Biaya',
            'kurungan_tahun' => 'Kurungan Tahun',
            'kurungan_bulan' => 'Kurungan Bulan',
            'kurungan_hari' => 'Kurungan Hari',
            'denda' => 'Denda',
            'putusan_tambahan' => 'Putusan Tambahan',
            'sikap_jaksa' => 'Sikap Jaksa',
            'sikap_terdakwa' => 'Sikap Terdakwa',
            'ph_penyidik_mulai' => 'Ph Penyidik Mulai',
            'ph_penyidik_selesai' => 'Ph Penyidik Selesai',
            'ph_penyidik_lokasi' => 'Ph Penyidik Lokasi',
            'ph_kejari_mulai' => 'Ph Kejari Mulai',
            'ph_kejari_selesai' => 'Ph Kejari Selesai',
            'ph_kejari_lokasi' => 'Ph Kejari Lokasi',
            'ph_pn_mulai' => 'Ph Pn Mulai',
            'ph_pn_selesai' => 'Ph Pn Selesai',
            'ph_pn_lokasi' => 'Ph Pn Lokasi',
            'umur' => 'Umur',
            'putusan_tetap' => 'Putusan Tetap',
            'tgl_eksekusi' => 'Tgl Eksekusi',
            'putusan_upaya_hukum' => 'Putusan Upaya Hukum',
            'tgl_ptsn_bndg_ksasi' => 'Tgl Ptsn Bndg Ksasi',
            'tgl_ptsn_pk_grasi' => 'Tgl Ptsn Pk Grasi',
            'tgl_eksekusi_pk_grasi' => 'Tgl Eksekusi Pk Grasi',
            'pj_pidana_coba_thn' => 'Pj Pidana Coba Thn',
            'pj_pidana_coba_bln' => 'Pj Pidana Coba Bln',
            'pj_pidana_coba_hari' => 'Pj Pidana Coba Hari',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoP16()
    {
        return $this->hasOne(P16::className(), ['no_p16' => 'no_p16']);
    }

    /*public function afterSave($insert, $changedAttributes)
    {
        if($insert == true){
            //echo $this->no_p16;exit;
            try{
                $username="simkari_baru";
                $password="bandung";
                $dbname="192.168.11.11/sismiop";
                $connection=oci_connect($username, $password, $dbname);

                $array = oci_parse($connection, "SELECT max(id)+1 FROM pdm_perkara");

                oci_execute($array);

                while($row=oci_fetch_array($array))

                {
                    $sql1="insert into PDM_TERSANGKA(nama, tempat_lahir,tgl_lahir, jkl, kewarganegaraan, alamat, pekerjaan, id_perkara)
                      VALUES('$this->nama','$this->tempat_lahir',TO_DATE('".$this->tgl_lahir."', 'yyyy/mm/dd'),'$this->jkl', '$this->kewarganegaraan', '$this->alamat', '$this->pekerjaan', '".$row[0]."')";

                    $result=oci_parse($connection,$sql1);
                    oci_execute($result);
                }


            }catch (ErrorException $e){
                if($e->getMessage()){
                    echo "<script>alert('Data gagal sinkron ke database simkari harap melakukan sinkronisasi manual'); window.location.assign('".Url::to('index')."');</script>";
                }

            }
        }
        parent::afterSave($insert, $changedAttributes);
    }*/
}
