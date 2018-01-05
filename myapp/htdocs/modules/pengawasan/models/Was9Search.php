<?php
namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was9;
use app\modules\pengawasan\components\FungsiComponent; 
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;

/**
 * Was9Search represents the model behind the search form about `app\models\Was9`.
 */
class Was9Search extends Was9
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_surat_was9', 'tanggal_was9', 'perihal_was9', 'lampiran_was9', 'no_register', 'jenis_saksi', 'hari_pemeriksaan_was9', 'tanggal_pemeriksaan_was9', 'jam_pemeriksaan_was9', 'tempat_pemeriksaan_was9', 'nip_penandatangan', 'nama_penandatangan', 'pangkat_penandatangan', 'golongan_penandatangan', 'jabatan_penandatangan', 'was9_file', 'id_sp_was','nomor_surat_was9', 'sifat_was9'], 'safe'],
        ];
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
    public function search($jns_saksi)
    {
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where();
        $query="select*from was.was9 where jenis_saksi='".$jns_saksi."' and no_register='".$no_register."' 
        and id_tingkat='".$_SESSION['kode_tk']."' 
        and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
        and id_cabjari='".$_SESSION['kode_cabjari']."' $where";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          // $query .=" where upper(nama) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(jabatan) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(instansi) like'%".strtoupper($keyWord)."%'";
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

    public function searchSaksiInt($jns_saksi,$id_saksi)
    {
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $query="select a.*,b.* from was.was9 a
                inner join was.saksi_internal b
                on a.id_tingkat = b.id_tingkat and
                a.id_kejati  = b.id_kejati and
                a.id_kejari  = b.id_kejari and
                a.id_cabjari = b.id_cabjari and
                a.id_saksi = b.id_saksi_internal and
                a.id_wilayah=b.id_wilayah and
                a.id_level1=b.id_level1 and 
                a.id_level2=b.id_level2 and
                a.id_level3=b.id_level3 and                                          
                a.id_level4=b.id_level4 and
				a.no_register=b.no_register
        where a.jenis_saksi='".$jns_saksi."' and a.no_register='".$_SESSION['was_register']."' 
        and a.id_tingkat='".$_SESSION['kode_tk']."' 
        and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
        and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_saksi=".$id_saksi." $where";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          // $query .=" where upper(nama) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(jabatan) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(instansi) like'%".strtoupper($keyWord)."%'";
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

    public function searchSaksiEks($jns_saksi,$id_saksi)
    {
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $query="select a.*,b.* from was.was9 a
                inner join was.saksi_eksternal b
                on a.id_tingkat = b.id_tingkat and
                a.id_kejati  = b.id_kejati and
                a.id_kejari  = b.id_kejari and
                a.id_cabjari = b.id_cabjari and
                a.id_saksi = b.id_saksi_eksternal and
                a.id_wilayah=b.id_wilayah and
                a.id_level1=b.id_level1 and  
                a.id_level2=b.id_level2 and
                a.id_level3=b.id_level3 and                                        
                a.id_level4=b.id_level4 and
				a.no_register=b.no_register
        where a.jenis_saksi='".$jns_saksi."' and a.no_register='".$_SESSION['was_register']."' 
        and a.id_tingkat='".$_SESSION['kode_tk']."' 
        and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
        and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_saksi=".$id_saksi." $where";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          // $query .=" where upper(nama) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(jabatan) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(instansi) like'%".strtoupper($keyWord)."%'";
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

     


    public function searchSaksiInternal()
    {

         $fungsi=new FungsiComponent();
         $where=$fungsi->static_where();
         $query="select * from was.saksi_internal where no_register='".$_SESSION['was_register']."'  
                and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' 
                and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' $where";        
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
            $query .=" and (upper(nip) like'%".strtoupper($keyWord)."%'";
            $query .=" or  upper(nama_saksi_internal) like'%".strtoupper($keyWord)."%'";
            $query .=" or  upper(jabatan_saksi_internal) like'%".strtoupper($keyWord)."%'";
            $query .=" or  upper(golongan_saksi_internal) like'%".strtoupper($keyWord)."%'";
            $query .=" or  upper(pangkat_saksi_internal) like'%".strtoupper($keyWord)."%')";
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

        public function searchSaksiEksternal()
    {
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where();
        $query="select*from was.saksi_eksternal where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' $where";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          $query .=" and (upper(nama_saksi_eksternal) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(alamat_saksi_eksternal) like'%".strtoupper($keyWord)."%'"; 
          $query .=" or  upper(nama_kota_saksi_eksternal) like'%".strtoupper($keyWord)."%')"; 
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

    public function searchPegawai($params)
    {
        $query="select*from kepegawaian.kp_pegawai";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          $query .=" where (upper(nama) like'%".strtoupper($keyWord)."%'";
           $query .=" or  upper(jabatan) like'%".strtoupper($keyWord)."%'";
           $query .=" or  upper(peg_nip_baru) like'%".strtoupper($keyWord)."%'";
           $query .=" or  upper(unitkerja_nama) like'%".strtoupper($keyWord)."%')";
          // $query .=" or  upper(instansi) like'%".strtoupper($keyWord)."%'";
         }


        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 8,
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
        $query="select*from was.v_penandatangan where id_surat='was9' and unitkerja_alias='".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."'";
        $keyWord  = htmlspecialchars($_GET['cari_penandatangan'], ENT_QUOTES);
        // $keyWord2  = htmlspecialchars($_GET['jns_penandatangan'], ENT_QUOTES);
         // if($_GET['jns_penandatangan']!=''){
         // }
         if($_GET['cari_penandatangan']!=''){
          $query .=" and  (upper(nama_jabatan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(jabtan_asli) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(nip) ='".($keyWord)."')";
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
}
