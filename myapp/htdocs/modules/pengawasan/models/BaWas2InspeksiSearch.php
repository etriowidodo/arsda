<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\BaWas2Inspeksi;
use yii\data\SqlDataProvider;
use yii\db\Query;

/**
 * BaWas2Search represents the model behind the search form about `app\modules\pengawasan\models\BaWas2Inspeksi`.
 */
class BaWas2InspeksiSearch extends BaWas2Inspeksi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba_was2', 'no_register', 'hari_ba_was_2', 'tgl_ba_was_2', 'tempat_ba_was_2', 'file_ba_was_2', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
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
   public function searchPenandatangan($params)
    {
        $query="select*from was.v_penandatangan where id_surat='Bawas2'";
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
	
	public function search($params)
    {
       $query = new Query;
         $query->select("*")
                ->from("was.ba_was_2 a")
				->where("a.no_register='".$_SESSION['was_register']."' and is_inspektur_irmud_riksa='".$_SESSION['is_inspektur_irmud_riksa']."'")
    //             ->join("inner join","was.pemeriksa_sp_was1 b","a.id_sp_was1=b.id_sp_was1")
				// ->join("inner join","was.pegawai_terlapor c","b.id_sp_was1=c.id_sp_was and for_tabel='Sp-Was-1'")
                ->orderBy(' a.created_time desc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }
		
        $query->andFilterWhere(['like', 'upper(a.id_ba_was_3)',strtoupper($params['BaWas2Search']['cari'])])
            ->orFilterWhere(['like', 'upper(a.no_register)',strtoupper($params['BaWas2Search']['cari'])]);


        return $dataProvider;
    }
	
	public function searchPemeriksa($params)
    {
		
		$query = new Query;
        $query->select('a.peg_nama, a.peg_nip_baru, a.jabatan')
                ->from('was.v_riwayat_jabatan a')
				->innerJoin('was.pemeriksa b on (a.id=b.id_h_jabatan) ')
				->where("b.no_register= :no_register", [':no_register' => $params]);

        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
			'pageSize' => 10,
			],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

 

        //$query->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
        //    ->andFilterWhere(['like', 'lower(inst_nama)', strtolower($this->inst_nama)]);

        return $dataProvider;
    }
	
	
	
	public function searchTerlapor($params)
    {
		
		$query = new Query;
        $query->select('a.*')
                ->from('was.v_ba_was_2_terlapor a')
				->innerJoin('was.ba_was_2 b on (a.id_ba_was2=b.id_ba_was2) ')
				->where("a.no_register= :no_register and b.flag='1'", [':no_register' => $params]);

        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
			'pageSize' => 5,
			],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

 

        //$query->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
        //    ->andFilterWhere(['like', 'lower(inst_nama)', strtolower($this->inst_nama)]);

        return $dataProvider;
    }
	
	
	public function searchInternal($params)
    {
		
		$query = new Query;
        $query->select('a.*')
                ->from('was.v_ba_was_2_saksi_internal a')
				->innerJoin('was.ba_was_2 b on (a.id_ba_was2=b.id_ba_was2) ')
				->where("a.no_register= :no_register and b.flag='1'", [':no_register' => $params]);

        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
			'pageSize' => 5,
			],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

 

        //$query->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
        //    ->andFilterWhere(['like', 'lower(inst_nama)', strtolower($this->inst_nama)]);

        return $dataProvider;
    }
	
	
	
	public function searchEksternal($params)
    {
		
		$query = new Query;
        $query->select('a.*')
                ->from('was.v_ba_was_2_saksi_eksternal a')
				->innerJoin('was.ba_was_2 b on (a.id_ba_was2=b.id_ba_was2) ')
				->where("a.no_register= :no_register and b.flag='1'", [':no_register' => $params]);

        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
			'pageSize' => 5,
			],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

 

        //$query->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
        //    ->andFilterWhere(['like', 'lower(inst_nama)', strtolower($this->inst_nama)]);

        return $dataProvider;
    }
	
}
