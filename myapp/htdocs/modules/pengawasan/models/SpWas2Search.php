<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\SpWas2;
use app\components\GlobalFuncComponent; 
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
/**
 * SpWas2Search represents the model behind the search form about `app\modules\pengawasan\models\SpWas2`.
 */
class SpWas2Search extends SpWas2
{
    public $cari;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sp_was2', 'jbtn_penandatangan', 'nomor_sp_was2', 'tanggal_sp_was2', 
            'tanggal_mulai_sp_was2', 'tanggal_akhir_sp_was2', 'nip_penandatangan',
             'nama_penandatangan', 'pangkat_penandatangan', 'golongan_penandatangan', 
             'jabatan_penandatangan', 'file_sp_was2', 'file_sp_was2', 'created_ip', 'created_time', 'updated_ip', 'updated_time','no_register','status_penandatangan'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
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
        $query="select*from was.v_spwas2 where no_register='".$_SESSION['was_register']."' 
                and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' 
                and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' 
                and id_wilayah='".$_SESSION['id_wil']."' and id_level1='".$_SESSION['id_level_1']."' 
                and id_level2='".$_SESSION['id_level_2']."' and id_level3='".$_SESSION['id_level_3']."' 
                and id_level4='".$_SESSION['id_level_4']."'";
        $keyWord  = htmlspecialchars($_GET['SpWas2Search']['cari'], ENT_QUOTES);
         if($_GET['SpWas2Search']['cari']!=''){
          $query .=" and upper(terlapor) like'%".strtoupper($keyWord)."%'";
          //$query .=" or  upper(no_register) like'%".strtoupper($keyWord)."%'";
          //$query .=" or  upper(pelapor) like'%".strtoupper($keyWord)."%'";
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

     public function searchTu($params)
    {
        $query="select*from was.was1 where id_level_was1='3' and id_saran in ('5','6')";
        $keyWord  = htmlspecialchars($_GET['SpWas2Search']['cari'], ENT_QUOTES);
         if($_GET['SpWas2Search']['cari']!=''){
          $query .=" where upper(terlapor) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(alamat) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(nama_penjamin) like'%".strtoupper($keyWord)."%'";
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

	 public function searchIndex_old($params)
    {
       $query = new Query;
//        $connection = \Yii::$app->db;
//           $query = "select a.*,(select nama_pemeriksa from was.pemeriksa_sp_was2 where id_sp_was2=a.id_sp_was2 limit 1) as nama_pemeriksa, 
// (select nama_pegawai_terlapor from was.pegawai_terlapor where id_sp_was=a.id_sp_was2 and for_tabel='Sp-Was-2' limit 1) as nama_terlapor
// from was.sp_was_2 a";
//           $query1 = $connection->createCommand($query)->queryAll();

         $query->select("a.*,(select nama_pemeriksa from was.pemeriksa_sp_was2 where id_sp_was2=a.id_sp_was2 limit 1) as nama_pemeriksa, 
                        (select nama_pegawai_terlapor from was.pegawai_terlapor where id_sp_was=a.id_sp_was2 and for_tabel='Sp-Was-2' limit 1) as nama_terlapor")
                ->from("was.sp_was_2 a")
    //             ->join("inner join","was.pemeriksa_sp_was2 b","a.id_sp_was2=b.id_sp_was2")
				// ->join("inner join","was.pegawai_terlapor c","b.id_sp_was2=c.id_sp_was and for_tabel='Sp-Was-2'")
                ->orderBy(' a.created_time desc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }
		
        $query->andFilterWhere(['like', 'upper(a.id_sp_was2)',strtoupper($params['SpWas1Search']['cari'])])
            ->orFilterWhere(['like', 'upper(a.nomor_sp_was2)',strtoupper($params['SpWas1Search']['cari'])])
            ->orFilterWhere(['like', 'upper(b.nama_pemeriksa)',strtoupper($params['SpWas1Search']['cari'])])
            ->orFilterWhere(['like', 'upper(b.jabatan_pemeriksa)',strtoupper($params['SpWas1Search']['cari'])])
            ->orFilterWhere(['like', 'upper(c.nama_terlapor_awal)',strtoupper($params['SpWas1Search']['cari'])])
			->orFilterWhere(['like', 'upper(c.jabatan_terlapor_awal)',strtoupper($params['SpWas1Search']['cari'])]);


        return $dataProvider;
    }
    public function search($params)
    {
        $query = SpWas2::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // $query->andFilterWhere([
        //     'tgl_sp_was_2' => $this->tgl_sp_was_2,
        //     'ttd_sp_was_2' => $this->ttd_sp_was_2,
        //     'tgl_1' => $this->tgl_1,
        //     'tgl_2' => $this->tgl_2,
        //     'anggaran' => $this->anggaran,
        //     'saran' => $this->saran,
        //     'flag' => $this->flag,
        //     'created_by' => $this->created_by,
        //     'created_time' => $this->created_time,
        //     'updated_by' => $this->updated_by,
        //     'updated_time' => $this->updated_time,
        // ]);

        $query->andFilterWhere(['like', 'upper(id_sp_was2)', strtoupper($params['SpWas2Search']['cari'])]);
        //     ->andFilterWhere(['like', 'no_sp_was_2', $this->no_sp_was_2])
        //     ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
        //     ->andFilterWhere(['like', 'id_register', $this->id_register])
        //     ->andFilterWhere(['like', 'perja', $this->perja])
        //     ->andFilterWhere(['like', 'thn_dipa', $this->thn_dipa])
        //     ->andFilterWhere(['like', 'ttd_peg_nik', $this->ttd_peg_nik])
        //     ->andFilterWhere(['like', 'ttd_id_jabatan', $this->ttd_id_jabatan])
        //     ->andFilterWhere(['like', 'upload_file', $this->upload_file])
        //     ->andFilterWhere(['like', 'created_ip', $this->created_ip])
        //     ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }

   public function searchPemeriksa($params)
    {

        $query="select a.peg_nip_baru,a.nama,a.jabatan,a.gol_pangkat2,a.gol_kd,a.peg_nrp,a.instansi from  kepegawaian.kp_pegawai a inner join kepegawaian.kp_inst_satker b
                on a.inst_satkerkd=b.inst_satkerkd where b.kode_tk='".$_SESSION['kode_tk']."' and b.kode_kejati='".$_SESSION['kode_kejati']."' and b.kode_kejari='".$_SESSION['kode_kejari']."' 
                and b.kode_cabjari='".$_SESSION['kode_cabjari']."'";
        $keyWord  = htmlspecialchars($_GET['cari_pemeriksa'], ENT_QUOTES);
         if($_GET['cari_pemeriksa']!=''){
          $query .=" and upper(a.nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(a.jabatan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(a.instansi) like'%".strtoupper($keyWord)."%'";
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
  public function searchPenandaTangan($params)
    {
       $query="select*from was.v_penandatangan where id_surat='spwas2' ";
        $keyWord  = htmlspecialchars($_GET['cari_penandatangan'], ENT_QUOTES);
         if($_GET['cari_penandatangan']!=''){
          $query .=" and  (upper(nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(nip) ='".($keyWord)."'";
          $query .=" or  upper(nama_jabatan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(jabtan_asli) like'%".strtoupper($keyWord)."%')";
		  //$query .=" order by id_jabatan";
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
