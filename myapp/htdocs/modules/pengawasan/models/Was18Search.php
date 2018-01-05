<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was18;
use yii\data\SqlDataProvider;
use yii\db\Query;

/**
 * Was18Search represents the model behind the search form about `app\modules\pengawasan\models\Was18`.
 */
class Was18Search extends Was18
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_was18', 'no_was_18', 'no_register', 'tgl_was_18', 'id_terlapor', 'upload_file', 'created_ip', 'created_time', 'updated_ip', 'updated_time', 'perihal'], 'safe'],
            [['sifat_surat', 'kpd_was_18', 'created_by', 'updated_by'], 'integer'],
        ];
        /*return [
            [['id_was18', 'no_was_18', 'no_register', 'inst_satkerkd', 'tgl_was_18', 'id_terlapor', 'ttd_peg_nik', 'upload_file', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time', 'perihal'], 'safe'],
            [['sifat_surat', 'jml_lampiran', 'satuan_lampiran', 'kpd_was_18', 'ttd_was_18', 'ttd_id_jabatan', 'created_by', 'updated_by'], 'integer'],
        ];*/
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Was18::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tgl_was_18' => $this->tgl_was_18,
            'sifat_surat' => $this->sifat_surat,
            'jml_lampiran' => $this->jml_lampiran,
            'satuan_lampiran' => $this->satuan_lampiran,
            'kpd_was_18' => $this->kpd_was_18,
            'ttd_was_18' => $this->ttd_was_18,
            'ttd_id_jabatan' => $this->ttd_id_jabatan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_was18', $this->id_was18])
            ->andFilterWhere(['like', 'no_was_18', $this->no_was_18])
            ->andFilterWhere(['like', 'no_register', $this->no_register])
            //->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
            ->andFilterWhere(['like', 'id_terlapor', $this->id_terlapor])
            ->andFilterWhere(['like', 'ttd_peg_nik', $this->ttd_peg_nik])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip])
            ->andFilterWhere(['like', 'perihal', $this->perihal]);

        return $dataProvider;
    }
    
    public function searchWas18(){ 
        $no_register    = $_SESSION['was_register'];
        $id_tingkat     = $_SESSION['kode_tk'];
        $id_kejati      = $_SESSION['kode_kejati'];
        $id_kejari      = $_SESSION['kode_kejari'];
        $id_cabjari     = $_SESSION['kode_cabjari'];
        $id_wilayah     = $_SESSION['was_id_wilayah'];
        $id_level1      = $_SESSION['was_id_level1'];
        $id_level2      = $_SESSION['was_id_level2'];
        $id_level3      = $_SESSION['was_id_level3'];
        $id_level4      = $_SESSION['was_id_level4'];
 
        $query="select * from was.was_18 where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."'and id_level4='".$_SESSION['was_id_level4']."'";
        $keyWord  = htmlspecialchars($_GET['cari_penerima'], ENT_QUOTES);
            if($_GET['cari_penerima']!=''){
            $query .=" where  upper(nama_pegawai_terlapor) like'%".strtoupper($keyWord)."%'"; 
            $query .=" or  upper(nip_pegawai_terlapor) like'%".strtoupper($keyWord)."%'";
            $query .=" or  upper(pangkat_pegawai_terlapor) like'%".strtoupper($keyWord)."%'";
        }


        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 10,
      ]
        ]);
        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }
        
        return $dataProvider;
    }

    public function searchTerlapor(){
        $noreg      = $_SESSION['was_register'];
        $id_tingkat = $_SESSION['kode_tk'];
        $id_kejati  = $_SESSION['kode_kejati']; 
        $id_kejari  = $_SESSION['kode_kejari']; 
        $id_cabjari = $_SESSION['kode_cabjari']; 
        //and id_kejari = '".$_SESSION['kode_kejari']."' and id_cabjari = '".$_SESSION['kode_cabjari'].'
        $query="
select a.pasal,b.isi_sk,a.nip_pegawai_terlapor, a.nama_pegawai_terlapor,a.pangkat_pegawai_terlapor,a.golongan_pegawai_terlapor, a.jabatan_pegawai_terlapor,a.id_sp_was2,a.id_ba_was2,a.id_l_was2,a.id_was15,'SK-WAS2-A'AS kode_sk,c.nip_pemeriksa,c.nrp_pemeriksa,c.nama_pemeriksa,c.pangkat_pemeriksa,c.golongan_pemeriksa,c.jabatan_pemeriksa,a.nrp_pegawai_terlapor,a.pelanggaran
from was.sk_was_2a a inner join was.ms_sk b on 'SK-WAS2-A'=b.kode_sk 
inner join was.was10_inspeksi c
on a.no_register = c.no_register
and a.id_tingkat=c.id_tingkat
and a.id_kejati=c.id_kejati
and a.id_kejari=c.id_kejari
and a.id_cabjari=c.id_cabjari
and a.id_wilayah=c.id_wilayah
and a.id_level1=c.id_level1
and a.id_level2=c.id_level2
and a.id_level3=c.id_level3
and a.id_level4=c.id_level4
and a.nip_pegawai_terlapor=c.nip_pegawai_terlapor
where a.no_register = '$noreg' and a.id_tingkat='$id_tingkat' and a.id_kejati='$id_kejati' and a.id_kejari='$id_kejari' and a.id_cabjari='$id_cabjari'  and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."' and c.trx_akhir=1
union
select a.pasal,b.isi_sk,a.nip_pegawai_terlapor, a.nama_pegawai_terlapor,a.pangkat_pegawai_terlapor,a.golongan_pegawai_terlapor, a.jabatan_pegawai_terlapor,a.id_sp_was2,a.id_ba_was2,a.id_l_was2,a.id_was15,'SK-WAS2-B'AS kode_sk,c.nip_pemeriksa,c.nrp_pemeriksa,c.nama_pemeriksa,c.pangkat_pemeriksa,c.golongan_pemeriksa,c.jabatan_pemeriksa,a.nrp_pegawai_terlapor,a.pelanggaran
from was.sk_was_2b a inner join was.ms_sk b on 'SK-WAS2-B'=b.kode_sk 
inner join was.was10_inspeksi c
on a.no_register = c.no_register
and a.id_tingkat=c.id_tingkat
and a.id_kejati=c.id_kejati
and a.id_kejari=c.id_kejari
and a.id_cabjari=c.id_cabjari
and a.id_wilayah=c.id_wilayah
and a.id_level1=c.id_level1
and a.id_level2=c.id_level2
and a.id_level3=c.id_level3
and a.id_level4=c.id_level4
and a.nip_pegawai_terlapor=c.nip_pegawai_terlapor
where a.no_register = '$noreg' and a.id_tingkat='$id_tingkat' and a.id_kejati='$id_kejati' and a.id_kejari='$id_kejari' and a.id_cabjari='$id_cabjari'  and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."' and c.trx_akhir=1
union
select a.pasal,b.isi_sk,a.nip_pegawai_terlapor, a.nama_pegawai_terlapor,a.pangkat_pegawai_terlapor,a.golongan_pegawai_terlapor, a.jabatan_pegawai_terlapor,a.id_sp_was2,a.id_ba_was2,a.id_l_was2,a.id_was15,'SK-WAS2-C'AS kode_sk,c.nip_pemeriksa,c.nrp_pemeriksa,c.nama_pemeriksa,c.pangkat_pemeriksa,c.golongan_pemeriksa,c.jabatan_pemeriksa,a.nrp_pegawai_terlapor,a.pelanggaran
from was.sk_was_2c a inner join was.ms_sk b on 'SK-WAS2-C'=b.kode_sk 
inner join was.was10_inspeksi c
on a.no_register = c.no_register
and a.id_tingkat=c.id_tingkat
and a.id_kejati=c.id_kejati
and a.id_kejari=c.id_kejari
and a.id_cabjari=c.id_cabjari
and a.id_wilayah=c.id_wilayah
and a.id_level1=c.id_level1
and a.id_level2=c.id_level2
and a.id_level3=c.id_level3
and a.id_level4=c.id_level4
and a.nip_pegawai_terlapor=c.nip_pegawai_terlapor
where a.no_register = '$noreg' and a.id_tingkat='$id_tingkat' and a.id_kejati='$id_kejati' and a.id_kejari='$id_kejari' and a.id_cabjari='$id_cabjari'  and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."' and c.trx_akhir=1
union
select a.pasal,b.isi_sk,a.nip_pegawai_terlapor, a.nama_pegawai_terlapor,a.pangkat_pegawai_terlapor,a.golongan_pegawai_terlapor, a.jabatan_pegawai_terlapor,a.id_sp_was2,a.id_ba_was2,a.id_l_was2,a.id_was15,'SK-WAS3-A'AS kode_sk,c.nip_pemeriksa,c.nrp_pemeriksa,c.nama_pemeriksa,c.pangkat_pemeriksa,c.golongan_pemeriksa,c.jabatan_pemeriksa,a.nrp_pegawai_terlapor,a.pelanggaran
from was.sk_was_3a a inner join was.ms_sk b on 'SK-WAS3-A'=b.kode_sk 
inner join was.was10_inspeksi c
on a.no_register = c.no_register
and a.id_tingkat=c.id_tingkat
and a.id_kejati=c.id_kejati
and a.id_kejari=c.id_kejari
and a.id_cabjari=c.id_cabjari
and a.id_wilayah=c.id_wilayah
and a.id_level1=c.id_level1
and a.id_level2=c.id_level2
and a.id_level3=c.id_level3
and a.id_level4=c.id_level4
and a.nip_pegawai_terlapor=c.nip_pegawai_terlapor
where a.no_register = '$noreg' and a.id_tingkat='$id_tingkat' and a.id_kejati='$id_kejati' and a.id_kejari='$id_kejari' and a.id_cabjari='$id_cabjari'  and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."' and c.trx_akhir=1
union
select a.pasal,b.isi_sk,a.nip_pegawai_terlapor, a.nama_pegawai_terlapor,a.pangkat_pegawai_terlapor,a.golongan_pegawai_terlapor, a.jabatan_pegawai_terlapor,a.id_sp_was2,a.id_ba_was2,a.id_l_was2,a.id_was15,'SK-WAS3-B'AS kode_sk,c.nip_pemeriksa,c.nrp_pemeriksa,c.nama_pemeriksa,c.pangkat_pemeriksa,c.golongan_pemeriksa,c.jabatan_pemeriksa,a.nrp_pegawai_terlapor,a.pelanggaran
from was.sk_was_3b a inner join was.ms_sk b on 'SK-WAS3-B'=b.kode_sk 
inner join was.was10_inspeksi c
on a.no_register = c.no_register
and a.id_tingkat=c.id_tingkat
and a.id_kejati=c.id_kejati
and a.id_kejari=c.id_kejari
and a.id_cabjari=c.id_cabjari
and a.id_wilayah=c.id_wilayah
and a.id_level1=c.id_level1
and a.id_level2=c.id_level2
and a.id_level3=c.id_level3
and a.id_level4=c.id_level4
and a.nip_pegawai_terlapor=c.nip_pegawai_terlapor
where a.no_register = '$noreg' and a.id_tingkat='$id_tingkat' and a.id_kejati='$id_kejati' and a.id_kejari='$id_kejari' and a.id_cabjari='$id_cabjari'  and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."' and c.trx_akhir=1
union
select a.pasal,b.isi_sk,a.nip_pegawai_terlapor, a.nama_pegawai_terlapor,a.pangkat_pegawai_terlapor,a.golongan_pegawai_terlapor, a.jabatan_pegawai_terlapor,a.id_sp_was2,a.id_ba_was2,a.id_l_was2,a.id_was15,'SK-WAS3-C'AS kode_sk,c.nip_pemeriksa,c.nrp_pemeriksa,c.nama_pemeriksa,c.pangkat_pemeriksa,c.golongan_pemeriksa,c.jabatan_pemeriksa,a.nrp_pegawai_terlapor,a.pelanggaran
from was.sk_was_3c a inner join was.ms_sk b on 'SK-WAS3-C'=b.kode_sk 
inner join was.was10_inspeksi c
on a.no_register = c.no_register
and a.id_tingkat=c.id_tingkat
and a.id_kejati=c.id_kejati
and a.id_kejari=c.id_kejari
and a.id_cabjari=c.id_cabjari
and a.id_wilayah=c.id_wilayah
and a.id_level1=c.id_level1
and a.id_level2=c.id_level2
and a.id_level3=c.id_level3
and a.id_level4=c.id_level4
and a.nip_pegawai_terlapor=c.nip_pegawai_terlapor
where a.no_register = '$noreg' and a.id_tingkat='$id_tingkat' and a.id_kejati='$id_kejati' and a.id_kejari='$id_kejari' and a.id_cabjari='$id_cabjari'  and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."' and c.trx_akhir=1
union
select a.pasal,b.isi_sk,a.nip_pegawai_terlapor, a.nama_pegawai_terlapor,a.pangkat_pegawai_terlapor,a.golongan_pegawai_terlapor, a.jabatan_pegawai_terlapor,a.id_sp_was2,a.id_ba_was2,a.id_l_was2,a.id_was15,'SK-WAS4-A'AS kode_sk,c.nip_pemeriksa,c.nrp_pemeriksa,c.nama_pemeriksa,c.pangkat_pemeriksa,c.golongan_pemeriksa,c.jabatan_pemeriksa,a.nrp_pegawai_terlapor,a.pelanggaran
from was.sk_was_4a a inner join was.ms_sk b on 'SK-WAS4-A'=b.kode_sk 
inner join was.was10_inspeksi c
on a.no_register = c.no_register
and a.id_tingkat=c.id_tingkat
and a.id_kejati=c.id_kejati
and a.id_kejari=c.id_kejari
and a.id_cabjari=c.id_cabjari
and a.id_wilayah=c.id_wilayah
and a.id_level1=c.id_level1
and a.id_level2=c.id_level2
and a.id_level3=c.id_level3
and a.id_level4=c.id_level4
and a.nip_pegawai_terlapor=c.nip_pegawai_terlapor
where a.no_register = '$noreg' and a.id_tingkat='$id_tingkat' and a.id_kejati='$id_kejati' and a.id_kejari='$id_kejari' and a.id_cabjari='$id_cabjari'  and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."' and c.trx_akhir=1
union
select a.pasal,b.isi_sk,a.nip_pegawai_terlapor, a.nama_pegawai_terlapor,a.pangkat_pegawai_terlapor,a.golongan_pegawai_terlapor, a.jabatan_pegawai_terlapor,a.id_sp_was2,a.id_ba_was2,a.id_l_was2,a.id_was15,'SK-WAS4-B'AS kode_sk,c.nip_pemeriksa,c.nrp_pemeriksa,c.nama_pemeriksa,c.pangkat_pemeriksa,c.golongan_pemeriksa,c.jabatan_pemeriksa,a.nrp_pegawai_terlapor,a.pelanggaran
from was.sk_was_4b a inner join was.ms_sk b on 'SK-WAS4-B'=b.kode_sk 
inner join was.was10_inspeksi c
on a.no_register = c.no_register
and a.id_tingkat=c.id_tingkat
and a.id_kejati=c.id_kejati
and a.id_kejari=c.id_kejari
and a.id_cabjari=c.id_cabjari
and a.id_wilayah=c.id_wilayah
and a.id_level1=c.id_level1
and a.id_level2=c.id_level2
and a.id_level3=c.id_level3
and a.id_level4=c.id_level4
and a.nip_pegawai_terlapor=c.nip_pegawai_terlapor
where a.no_register = '$noreg' and a.id_tingkat='$id_tingkat' and a.id_kejati='$id_kejati' and a.id_kejari='$id_kejari' and a.id_cabjari='$id_cabjari'  and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."' and c.trx_akhir=1
union
select a.pasal,b.isi_sk,a.nip_pegawai_terlapor, a.nama_pegawai_terlapor,a.pangkat_pegawai_terlapor,a.golongan_pegawai_terlapor, a.jabatan_pegawai_terlapor,a.id_sp_was2,a.id_ba_was2,a.id_l_was2,a.id_was15,'SK-WAS4-C'AS kode_sk,c.nip_pemeriksa,c.nrp_pemeriksa,c.nama_pemeriksa,c.pangkat_pemeriksa,c.golongan_pemeriksa,c.jabatan_pemeriksa,a.nrp_pegawai_terlapor,a.pelanggaran
from was.sk_was_4c a inner join was.ms_sk b on 'SK-WAS4-C'=b.kode_sk 
inner join was.was10_inspeksi c
on a.no_register = c.no_register
and a.id_tingkat=c.id_tingkat
and a.id_kejati=c.id_kejati
and a.id_kejari=c.id_kejari
and a.id_cabjari=c.id_cabjari
and a.id_wilayah=c.id_wilayah
and a.id_level1=c.id_level1
and a.id_level2=c.id_level2
and a.id_level3=c.id_level3
and a.id_level4=c.id_level4
and a.nip_pegawai_terlapor=c.nip_pegawai_terlapor
where a.no_register = '$noreg' and a.id_tingkat='$id_tingkat' and a.id_kejati='$id_kejati' and a.id_kejari='$id_kejari' and a.id_cabjari='$id_cabjari'  and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."' and c.trx_akhir=1
union
select a.pasal,b.isi_sk,a.nip_pegawai_terlapor, a.nama_pegawai_terlapor,a.pangkat_pegawai_terlapor,a.golongan_pegawai_terlapor, a.jabatan_pegawai_terlapor,a.id_sp_was2,a.id_ba_was2,a.id_l_was2,a.id_was15,'SK-WAS4-D'AS kode_sk,c.nip_pemeriksa,c.nrp_pemeriksa,c.nama_pemeriksa,c.pangkat_pemeriksa,c.golongan_pemeriksa,c.jabatan_pemeriksa,a.nrp_pegawai_terlapor,a.pelanggaran
from was.sk_was_4d a inner join was.ms_sk b on 'SK-WAS4-D'=b.kode_sk 
inner join was.was10_inspeksi c
on a.no_register = c.no_register
and a.id_tingkat=c.id_tingkat
and a.id_kejati=c.id_kejati
and a.id_kejari=c.id_kejari
and a.id_cabjari=c.id_cabjari
and a.id_wilayah=c.id_wilayah
and a.id_level1=c.id_level1
and a.id_level2=c.id_level2
and a.id_level3=c.id_level3
and a.id_level4=c.id_level4
and a.nip_pegawai_terlapor=c.nip_pegawai_terlapor
where a.no_register = '$noreg' and a.id_tingkat='$id_tingkat' and a.id_kejati='$id_kejati' and a.id_kejari='$id_kejari' and a.id_cabjari='$id_cabjari'  and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."' and c.trx_akhir=1
union
select a.pasal,b.isi_sk,a.nip_pegawai_terlapor, a.nama_pegawai_terlapor,a.pangkat_pegawai_terlapor,a.golongan_pegawai_terlapor, a.jabatan_pegawai_terlapor,a.id_sp_was2,a.id_ba_was2,a.id_l_was2,a.id_was15,'SK-WAS4-E'AS kode_sk,c.nip_pemeriksa,c.nrp_pemeriksa,c.nama_pemeriksa,c.pangkat_pemeriksa,c.golongan_pemeriksa,c.jabatan_pemeriksa,a.nrp_pegawai_terlapor,a.pelanggaran
from was.sk_was_4e a inner join was.ms_sk b on 'SK-WAS4-E'=b.kode_sk 
inner join was.was10_inspeksi c
on a.no_register = c.no_register
and a.id_tingkat=c.id_tingkat
and a.id_kejati=c.id_kejati
and a.id_kejari=c.id_kejari
and a.id_cabjari=c.id_cabjari
and a.id_wilayah=c.id_wilayah
and a.id_level1=c.id_level1
and a.id_level2=c.id_level2
and a.id_level3=c.id_level3
and a.id_level4=c.id_level4
and a.nip_pegawai_terlapor=c.nip_pegawai_terlapor
where a.no_register = '$noreg' and a.id_tingkat='$id_tingkat' and a.id_kejati='$id_kejati' and a.id_kejari='$id_kejari' and a.id_cabjari='$id_cabjari'  and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."' and c.trx_akhir=1";
        $keyWord  = htmlspecialchars($_GET['cari_terlapor'], ENT_QUOTES);
            if($_GET['cari_penandatangan']!=''){ 
            $query .=" and  upper(nama_terlapor) like'%".strtoupper($keyWord)."%'";
            $query .=" or  upper(nip_terlapor) ='".($keyWord)."'";
            $query .=" or  upper(nrp_terlapor) like'%".strtoupper($keyWord)."%'";
            $query .=" or  upper(jabatan_terlapor) like'%".strtoupper($keyWord)."%'";
        }


        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 10,
      ]
        ]);
        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }
        
        return $dataProvider;
    }

    public function searchPenandatangan($params)
    {
        $query="select*from was.v_penandatangan where id_surat='was18' and unitkerja_alias='".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."'";
        $keyWord  = htmlspecialchars($_GET['cari_penandatangan'], ENT_QUOTES);
         if($_GET['cari_penandatangan']!=''){
          $query .=" and  (upper(nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(nip) ='".($keyWord)."'";
          $query .=" or  upper(nama_jabatan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(jabtan_asli) like'%".strtoupper($keyWord)."%')";
         }


        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 10,
      ]
        ]);
        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }
        
        return $dataProvider;
    }
    
    public function searchDataWas18($no_register){
        $query = new Query;
        $query ->select('a.peg_nama,a.peg_nip_baru, a.jabatan, c.no_was_18,c.id_was18,c.no_register')
                ->from('was.v_riwayat_jabatan a')
                 ->innerjoin('was.terlapor b','a.id=b.id_h_jabatan')
                 ->innerjoin('was.was_18 c','b.id_terlapor=c.id_terlapor')
                 ->where(['c.no_register' =>$no_register])
                 ->andWhere('c.flag != :del', ['del'=>'3'])
                 ->all();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            return $dataProvider;
        }
        return $dataProvider;    
    }
}
