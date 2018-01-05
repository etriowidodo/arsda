<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was17;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;

/**
 * Was17Search represents the model behind the search form about `app\modules\pengawasan\models\Was17`.
 */
class Was17Search extends Was17
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_was_17', 'created_time', 'updated_time',
               'id_tingkat','id_kejati', 'id_kejari', 'id_cabjari','no_register','dari_was_17','kpd_was_17',
               'id_terlapor','created_ip','updated_ip','upload_file',
               'satker_pegawai_terlapor','jabatan_penandatangan','jbtn_penandatangan','jabatan_mkj','jbtn_mkj',
               'golongan_mkj','pangkat_pegawai_terlapor','pangkat_penandatangan','nip_penandatangan','lampiran',
               'pangkat_mkj','golongan_pegawai_terlapor','no_was_17','golongan_penandatangan','perihal',
               'nama_pegawai_terlapor','jabatan_pegawai_terlapor','nama_penandatangan','nama_mkj',
               'nrp_pegawai_terlapor','nip_pegawai_terlapor','nip_mkj','sk'], 'safe'],
            [['id_sp_was2','id_ba_was2','id_l_was2','id_was15','id_was_17','id_wilayah','id_level1','id_level2','id_level3','id_level4','sifat_surat','created_by','updated_by'], 'integer'],
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
      public function search($params)
    {
        $query="select a.* from was.was_17 a where a.no_register='".$_SESSION['was_register']."'  
        and a.id_tingkat='".$_SESSION['kode_tk']."' 
        and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
        and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_wilayah='".$_SESSION['was_id_wilayah']."' 
        and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' 
        and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."'";
        $keyWord  = htmlspecialchars($_GET['cari_terlapor'], ENT_QUOTES);
         if($_GET['cari_terlapor']!=''){
          // $query .=" and  upper(nama_terlapor) like'%".strtoupper($keyWord)."%'";
          // $query .=" or nip_terlapor ='".$keyWord."'";
          // $query .=" or  upper(jabatan_terlapor) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(pangkat_terlapor) like'%".strtoupper($keyWord)."%'";
          
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
    
    public function searchDataWas17($id_register){
        $query = new Query;
        $query ->select('a.peg_nama,a.peg_nip_baru, a.jabatan, c.no_was_17,c.id_was_17,c.id_register')
                ->from('was.v_riwayat_jabatan a')
                 ->innerjoin('was.terlapor b','a.id=b.id_h_jabatan')
                 ->innerjoin('was.was_17 c','b.id_terlapor=c.id_terlapor')
                 ->where(['c.id_register' =>$id_register])
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

     public function searchTerlapor($params)
    {
        /*saran jamwas sk pemberhentian tidak hormat*/
        $query="select * from was.was_16d where sk in ('SK-WAS4-D','SK-WAS4-E') and no_register='".$_SESSION['was_register']."'  
                and id_tingkat='".$_SESSION['kode_tk']."' 
                and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' 
                and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' 
                and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
               // print_r($query);
        $keyWord  = htmlspecialchars($_GET['cari_terlapor'], ENT_QUOTES);
         if($_GET['cari_terlapor']!=''){
          $query .=" and  upper(nama_terlapor) like'%".strtoupper($keyWord)."%'";
          $query .=" or nip_terlapor ='".$keyWord."'";
          $query .=" or  upper(jabatan_terlapor) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(pangkat_terlapor) like'%".strtoupper($keyWord)."%'";
          
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
        $query="select*from was.v_penandatangan where id_surat='spwas1' ";
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

    public function searchMkj($params)
    {
        $query="select*from was.v_penandatangan where id_surat='spwas1' ";
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
