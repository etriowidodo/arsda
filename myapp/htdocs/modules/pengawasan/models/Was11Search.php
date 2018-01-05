<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was11;
use app\modules\pengawasan\components\FungsiComponent;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;
/**
 * Was11Search represents the model behind the search form about `app\modules\pengawasan\models\Was11`.
 */
class Was11Search extends Was11
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_surat_was11', 'no_was_11','no_register', 'tgl_was_11', 'perihal', 'nip_penandatangan', 'jabatan_penandatangan', 'upload_file', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['sifat_surat','created_by', 'updated_by'], 'integer'],
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
    public function searchInt($params)
    {
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where('a');
        $query="select*from(select a.*,(select string_agg(nip_saksi_internal||'-'||nama_saksi_internal,'#')from was.was_11_detail_int where id_was_11=a.id_surat_was11 and no_register=a.no_register and id_tingkat=a.id_tingkat and id_kejati=a.id_kejati and id_kejari=a.id_kejari and id_cabjari=a.id_cabjari and id_wilayah=a.id_wilayah and id_level1=a.id_level1 and id_level2=a.id_level2 and id_level3=a.id_level3 and id_level4=a.id_level4) as nama_saksi_internal
                from was.was11 a     
                    
                where a.id_tingkat::text = '".$_SESSION['kode_tk']."' AND a.id_kejati::text ='".$_SESSION['kode_kejati']."'  AND a.id_kejari::text ='".$_SESSION['kode_kejari']."' AND a.id_cabjari::text ='".$_SESSION['kode_cabjari']."'  AND a.no_register::text ='".$_SESSION['was_register']."' and a.jenis_saksi='Internal'  $where)x";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          $query .=" where (upper(x.no_register) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(x.nama_saksi_internal) like'%".strtoupper($keyWord)."%'"; 
          $query .=" or  upper(x.kepada_was11) like'%".strtoupper($keyWord)."%')"; 
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

    public function searchEks($params)
    {
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $query="select*from (select a.*,(select string_agg(nama_saksi_eksternal,'#')from 
                was.was_11_detail_eks where id_was_11=a.id_surat_was11 and no_register=a.no_register 
                and id_tingkat=a.id_tingkat and id_kejati=a.id_kejati and id_kejari=a.id_kejari 
                and id_cabjari=a.id_cabjari and id_wilayah=a.id_wilayah and id_level1=a.id_level1 
                and id_level2=a.id_level2 and id_level3=a.id_level3 and id_level4=a.id_level4) as 
                nama_saksi_eksternal
                from was.was11 a 
               where a.id_tingkat::text = '".$_SESSION['kode_tk']."' 
               AND a.id_kejati::text ='".$_SESSION['kode_kejati']."'  
               AND a.id_kejari::text ='".$_SESSION['kode_kejari']."' 
               AND a.id_cabjari::text ='".$_SESSION['kode_cabjari']."'  
               AND a.no_register::text ='".$_SESSION['was_register']."' 
               and a.jenis_saksi='Eksternal' $where )y";
        //  print_r($query);
        $keyWord  = htmlspecialchars($_GET['carieks'], ENT_QUOTES);
         if($_GET['carieks']!=''){
          $query .=" where (upper(y.no_register) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(y.nama_saksi_eksternal) like'%".strtoupper($keyWord)."%'"; 
          $query .=" or  upper(y.kepada_was11) like'%".strtoupper($keyWord)."%')"; 
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

    public function searchsaksi_int($params)
    {
      $fungsi=new FungsiComponent();
      $where=$fungsi->static_where_alias('a');
		$query="select *from was.saksi_internal b left join was.was9 a
      on b.id_saksi_internal=a.id_saksi
                and b.id_tingkat=a.id_tingkat
                and b.id_kejati=a.id_kejati
                AND b.id_kejari =a.id_kejari
                AND b.id_cabjari =a.id_cabjari
                AND b.no_register = a.no_register
                AND b.id_wilayah=a.id_wilayah
                AND b.id_level1=a.id_level1
                AND b.id_level2=a.id_level2
                AND b.id_level3=a.id_level3
                AND b.id_level4=a.id_level4
                AND b.no_register=a.no_register
      where a.id_tingkat::text = '".$_SESSION['kode_tk']."' AND a.id_kejati::text ='".$_SESSION['kode_kejati']."'  AND a.id_kejari::text ='".$_SESSION['kode_kejari']."' AND a.id_cabjari::text ='".$_SESSION['kode_cabjari']."'  AND a.no_register::text ='".$_SESSION['was_register']."'  AND a.trx_akhir=1 and a.jenis_saksi='Internal' $where";
        $keyWord  = htmlspecialchars($_GET['Was12Search']['cari'], ENT_QUOTES);
         if($_GET['Was12Search']['cari']!=''){
          // $query .=" and upper(b.nama_pegawai_terlapor) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(b.kepada_was12) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(b.di_was12) like'%".strtoupper($keyWord)."%'";
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

    public function searchsaksi_eks($params)
    {
      $fungsi=new FungsiComponent();
      $where=$fungsi->static_where_alias('a');
      $query="select *from was.saksi_eksternal b inner join was.was9 a 
                on b.id_saksi_eksternal=a.id_saksi
                and b.id_tingkat=a.id_tingkat
                and b.id_kejati=a.id_kejati
                AND b.id_kejari = a.id_kejari
                AND b.id_cabjari = a.id_cabjari
                AND b.no_register = a.no_register
                AND b.id_wilayah=a.id_wilayah
                AND b.id_level1=a.id_level1
                AND b.id_level2=a.id_level2
                AND b.id_level3=a.id_level3
                AND b.id_level4=a.id_level4
                AND b.no_register=a.no_register
       where a.id_tingkat::text = '".$_SESSION['kode_tk']."' AND a.id_kejati::text ='".$_SESSION['kode_kejati']."'  AND a.id_kejari::text ='".$_SESSION['kode_kejari']."' AND a.id_cabjari::text ='".$_SESSION['kode_cabjari']."'  AND a.no_register::text ='".$_SESSION['was_register']."'  AND a.trx_akhir=1 and a.jenis_saksi='Eksternal' $where";
        $keyWord  = htmlspecialchars($_GET['Was12Search']['cari'], ENT_QUOTES);
         if($_GET['Was12Search']['cari']!=''){
          // $query .=" and upper(b.nama_pegawai_terlapor) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(b.kepada_was12) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(b.di_was12) like'%".strtoupper($keyWord)."%'";
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
        $query="select*from was.v_penandatangan where id_surat='was11' and unitkerja_alias='".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."'";
        $keyWord  = htmlspecialchars($_GET['cari_penandatangan'], ENT_QUOTES);
         if($_GET['cari_penandatangan']!=''){
          $query .=" and  upper(nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(nip) ='".($keyWord)."'";
          $query .=" or  upper(nama_jabatan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(jabtan_asli) like'%".strtoupper($keyWord)."%'";
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
