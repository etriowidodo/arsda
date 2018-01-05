<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was14b;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;


/**
 * Was15Search represents the model behind the search form about `app\modules\pengawasan\models\Was15`.
 */
class Was14bSearch extends Was14b
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_was14b', 'no_register', 'no_was14b', 'perihal_was14b', 'di_was14b', 'golongan_terlapor', 'golongan_penandatangan', 'lampiran_was14b', 'kepada_was14b', 'pasal_pelanggaran', 'satker_terlapor', 'nama_penandatangan','nip_terlapor','nrp_terlapor','nama_terlapor','jabatan_penandatangan','jbtn_penandatangan','pangkat_terlapor','nip_penandatangan','pangkat_penandatangan','created_ip'], 'safe'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was14b', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'sifat_was14b','created_by'], 'integer'],
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
        $query="select a.* from was.was_14b a where 
                a.no_register='".$_SESSION['was_register']."'   
                AND a.id_tingkat='".$_SESSION['kode_tk']."' 
                AND a.id_kejati='".$_SESSION['kode_kejati']."' 
                AND a.id_kejari='".$_SESSION['kode_kejari']."' 
                AND a.id_cabjari='".$_SESSION['kode_cabjari']."' 
                AND a.id_wilayah='".$_SESSION['was_id_wilayah']."'
                AND a.id_level1='".$_SESSION['was_id_level1']."'
                AND a.id_level2='".$_SESSION['was_id_level2']."'
                AND a.id_level3='".$_SESSION['was_id_level3']."'
                AND a.id_level4='".$_SESSION['was_id_level4']."'";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          $query .=" and  (upper(no_was14b) like'%".strtoupper($keyWord)."%'"; 
          $query .=" or  upper(nip_terlapor) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(nama_terlapor) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(kepada_was14b) like'%".strtoupper($keyWord)."%')";
          
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

    public function searchTerlapor($params)
    {
        /*saran_l_was_2=1 adalah yang dilanjutkan*/
        $query="select a.*,b.pasal,b.isi_sk from was.l_was_2_terlapor a 
                inner join was.ms_sk b on a.saran_pasal=b.kode_sk where a.saran_l_was_2='1' 
                AND no_register='".$_SESSION['was_register']."'   
                AND id_tingkat='".$_SESSION['kode_tk']."' 
                AND id_kejati='".$_SESSION['kode_kejati']."' 
                AND id_kejari='".$_SESSION['kode_kejari']."' 
                AND id_cabjari='".$_SESSION['kode_cabjari']."' 
                AND a.id_wilayah='".$_SESSION['was_id_wilayah']."'
                AND a.id_level1='".$_SESSION['was_id_level1']."'
                AND a.id_level2='".$_SESSION['was_id_level2']."'
                AND a.id_level3='".$_SESSION['was_id_level3']."'
                AND a.id_level4='".$_SESSION['was_id_level4']."' ";
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
        $query="select*from was.v_penandatangan where id_surat='was14binsp' and unitkerja_alias='".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."'";
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

    
   }
