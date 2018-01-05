<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\BaWas7;
use app\modules\pengawasan\components\FungsiComponent;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;

/**
 * BaWas7Search represents the model behind the search form about `app\modules\pengawasan\models\BaWas7`.
 */
class BaWas7Search extends BaWas7
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_ba_was_7', 'id_wilayah', 'id_level1', 
            'id_level2', 'id_level3', 'id_level4', 'created_by', 'updated_by', 'id_was_16b'], 'integer'],
            [['tgl_ba_was_7', 'created_time', 'updated_time', 'id_tingkat', 'id_kejati','no_register',
            'tempat', 'nama_penyampai', 'nama_terlapor', 'nama_saksi1', 'nama_saksi2',
            'nip_penyampai', 'nip_terlapor', 'nip_saksi1', 'nip_saksi2', 'created_ip', 'updated_ip',
            'nrp_penyampai', 'nrp_terlapor', 'nrp_saksi1', 'nrp_saksi2',
            'pangkat_penyampai', 'pangkat_terlapor', 'pangkat_saksi1', 'pangkat_saksi2',
            'golongan_penyampai', 'golongan_terlapor', 'golongan_saksi1', 'golongan_saksi2','no_was_16b',
            'jabatan_penyampai', 'jabatan_terlapor', 'jabatan_saksi1', 'jabatan_saksi2','upload_file'], 'integer'],
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
      /*select a.*,b.* from was.was_16b a inner join was.was_16b_isi b
                on a.id_was_16b=b.id_was_16b
                order by a.id_was_16b,b.no_urut_isi*/
        $query="select*from was.ba_was_7 where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
        and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
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

    public function search_old($params)
    {
        $query = BaWas7::find();

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
            'tgl_ba_was_7' => $this->tgl_ba_was_7,
            'terima_tolak' => $this->terima_tolak,
            'penyampai_id_jabatan' => $this->penyampai_id_jabatan,
            'ttd_id_jabatan' => $this->ttd_id_jabatan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_ba_was_7', $this->id_ba_was_7])
            ->andFilterWhere(['like', 'no_ba_was_7', $this->no_ba_was_7])
            ->andFilterWhere(['like', 'id_register', $this->id_register])
            ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
            ->andFilterWhere(['like', 'hari', $this->hari])
            ->andFilterWhere(['like', 'tempat', $this->tempat])
            ->andFilterWhere(['like', 'id_terlapor', $this->id_terlapor])
            ->andFilterWhere(['like', 'penyampai_peg_nik', $this->penyampai_peg_nik])
            ->andFilterWhere(['like', 'ttd_peg_nik', $this->ttd_peg_nik])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
	
	
	public function searchBawas7($params)
    {
		
		$query = new Query;
        $query->select('a.peg_nama, a.peg_nip, a.jabatan, c.id_ba_was_7')
                ->from('was.v_terlapor a')
				->innerJoin('was.ba_was_7 c on (a.id_terlapor=c.id_terlapor) ')
				->where("c.id_register= :id_register and c.flag='1'", [':id_register' => $params]);

        
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
        $query->select('a.id_saksi_internal,a.peg_nip,a.peg_nama,a.jabatan')
                ->from('was.v_saksi_internal a')
				->innerJoin('was.saksi_internal b on (a.id_saksi_internal=b.id_saksi_internal)')
				->where("b.id_register= :id_register and b.ba_was_7 = 1", [':id_register' => $params]);

        
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
/*and a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";*/

    public function searchBawas7Saksi1($params)
    {        
        $query="select * from kepegawaian.kp_pegawai"; 
                    
        $keyWord  = htmlspecialchars($_GET['cari_saksi1'], ENT_QUOTES);
         if($_GET['cari_saksi1']!=''){
          $query .=" where upper(nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  peg_nip_baru like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(instansi) like'%".strtoupper($keyWord)."%'";
         }


        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.") a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 5,
      ]
        ]);
        $this->load($params);
        if (!$this->validate()) {

            return $dataProvider;
        }
        return $dataProvider;
    }

    public function searchBawas7Saksi2($params)
    {        
        $query="select * from kepegawaian.kp_pegawai"; 
                    
        $keyWord  = htmlspecialchars($_GET['cari_saksi2'], ENT_QUOTES);
         if($_GET['cari_saksi2']!=''){
          $query .=" where upper(nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  peg_nip_baru like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(instansi) like'%".strtoupper($keyWord)."%'";
         }


        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.") a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 5,
      ]
        ]);
        $this->load($params);
        if (!$this->validate()) {

            return $dataProvider;
        }
        return $dataProvider;
    }

     public function searchBawas7Petugas($params)
    {        
        $query="select * from kepegawaian.kp_pegawai"; 
                    
        $keyWord  = htmlspecialchars($_GET['cari_petugas'], ENT_QUOTES);
         if($_GET['cari_petugas']!=''){
          $query .=" where upper(nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  peg_nip_baru like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(instansi) like'%".strtoupper($keyWord)."%'";
         }


        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.") a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 5,
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
        /*saran jamwas sk pemberhentian tidak hormat*/
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $query="select*from was.was_16b a inner join was.was_15_rencana b
                    on a.nip_pegawai_terlapor=b.nip_terlapor and
                    a.no_register=b.no_register and
                    a.id_tingkat=b.id_tingkat and
                    a.id_kejati=b.id_kejati and
                    a.id_kejari=b.id_kejari and
                    a.id_cabjari=b.id_cabjari and
                    a.id_wilayah=b.id_wilayah and
                    a.id_level1=b.id_level1 and
                    a.id_level2=b.id_level2 and
                    a.id_level3=b.id_level3 and
                    a.id_level4=b.id_level4 and
                    b.saran_dari='Jamwas'  where a.no_register='".$_SESSION['was_register']."' 
                    and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where ";
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
	
}
