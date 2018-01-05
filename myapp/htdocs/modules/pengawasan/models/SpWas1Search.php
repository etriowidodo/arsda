<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\SpWas1;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;
/**
 * SpWas1Search represents the model behind the search form about `app\modules\pengawasan\models\SpWas1`.
 */
class SpWas1Search extends SpWas1
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'updated_by'], 'integer'],
            [['nomor_sp_was1', 'tanggal_sp_was1', 'tanggal_mulai_sp_was1', 'tanggal_akhir_sp_was1', 'nip_penandatangan', 'nama_penandatangan', 'pangkat_penandatangan', 'golongan_penandatangan', 'jabatan_penandatangan', 'file_sp_was1', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
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

   
	public function searchIndex($params)
    {
        $query="select*from was.v_spwas where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['id_wil']."' and id_level1='".$_SESSION['id_level_1']."' and id_level2='".$_SESSION['id_level_2']."' and id_level3='".$_SESSION['id_level_3']."' and id_level4='".$_SESSION['id_level_4']."'";
        $keyWord  = htmlspecialchars($_GET['SpWas1Search']['cari'], ENT_QUOTES);
         if($_GET['SpWas1Search']['cari']!=''){
          $query .=" and (upper(nomor_sp_was1) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(terlapor) like'%".strtoupper($keyWord)."%')"; 
         }


        // add conditions that should always apply here

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

    public function searchPemeriksa($params)
    {
        $query="select peg_nip_baru,nama,jabatan,gol_pangkat2,gol_kd,peg_nrp,instansi from kepegawaian.kp_pegawai where inst_satkerkd='".$_SESSION['inst_satkerkd']."' and unitkerja_idk='1.6'";
        $keyWord  = htmlspecialchars($_GET['cari_pemeriksa'], ENT_QUOTES);
         if($_GET['cari_pemeriksa']!=''){
          $query .=" and upper(nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(jabatan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(instansi) like'%".strtoupper($keyWord)."%'";
         }


        // add conditions that should always apply here

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
        $query="select peg_nip_baru,nama,jabatan,gol_pangkat2,gol_kd,peg_nrp,instansi from kepegawaian.kp_pegawai";
        $keyWord  = htmlspecialchars($_GET['cari_pemeriksa'], ENT_QUOTES);
         if($_GET['cari_pemeriksa']!=''){
          $query .=" where upper(nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(jabatan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(instansi) like'%".strtoupper($keyWord)."%'";
         }


        // add conditions that should always apply here

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
        $query="select*from was.v_penandatangan where id_surat='spwas1'";
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
