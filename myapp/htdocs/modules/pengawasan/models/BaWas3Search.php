<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\BaWas3;
use app\modules\pengawasan\components\FungsiComponent;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;

/**
 * BaWas3Search represents the model behind the search form about `app\modules\pengawasan\models\BaWas3`.
 */
class BaWas3Search extends BaWas3
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id_ba_was_3', 'inst_satkerkd', 'no_register', 'hari', 'tgl', 'tempat', 'bawas3_file', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            // [['tunggal_jamak', 'id_pemeriksa', 'sebagai', 'id_peran', 'created_by', 'updated_by'], 'integer'],
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
        $query = BaWas3::find(['no_register'=>$_SESSION['was_register']]);

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
            'tgl' => $this->tgl,
            'id_pemeriksa' => $this->id_pemeriksa,
            'sebagai' => $this->sebagai,
            'id_peran' => $this->id_peran,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_ba_was_3', $this->id_ba_was_3])
            ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
            ->andFilterWhere(['like', 'no_register', $this->no_register])
            ->andFilterWhere(['like', 'hari', $this->hari])
            ->andFilterWhere(['like', 'tempat', $this->tempat])
            ->andFilterWhere(['like', 'bawas3_file', $this->bawas3_file])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
	
	public function searchIndex($params)
     {
		$fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $query="select *from(select a.tanggal_ba_was3,a.id_ba_was3,a.id_terlapor_saksi, b.nama_pegawai_terlapor as nama_dimintai_keterangan, a.nama_pemeriksa,
                CASE WHEN a.sebagai=0 THEN 'Terlapor'
                        ELSE ''
                   END
                   keterangan from was.ba_was_3 a
                INNER JOIN was.pegawai_terlapor_was10 b on a.id_terlapor_saksi::int=b.id_pegawai_terlapor and a.sebagai=0 and a.no_register=b.no_register and a.id_kejati=b.id_kejati and a.id_kejari=b.id_kejari and a.id_cabjari=b.id_cabjari 
				where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
        and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
        and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where
                UNION ALL
                select a.tanggal_ba_was3,a.id_ba_was3,a.id_terlapor_saksi, b.nama_saksi_internal as nama_dimintai_keterangan,a.nama_pemeriksa,
                    CASE WHEN a.sebagai=1 THEN 'Saksi Internal'
                            ELSE ''
                       END keterangan from was.ba_was_3 a
                INNER JOIN was.saksi_internal b on a.id_terlapor_saksi::int=b.id_saksi_internal and a.sebagai=1 and a.no_register=b.no_register and a.id_kejati=b.id_kejati and a.id_kejari=b.id_kejari and a.id_cabjari=b.id_cabjari
				where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
        and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
        and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where
                UNION ALL
                select a.tanggal_ba_was3,a.id_ba_was3,a.id_terlapor_saksi, b.nama_saksi_eksternal as nama_dimintai_keterangan,a.nama_pemeriksa,
                    CASE WHEN a.sebagai=2 THEN 'Saksi Eksternal'
                            ELSE ''
                       END  keterangan from was.ba_was_3 a
                INNER JOIN was.saksi_eksternal b on a.id_terlapor_saksi::int=b.id_saksi_eksternal and a.sebagai=2 and a.no_register=b.no_register and a.id_kejati=b.id_kejati and a.id_kejari=b.id_kejari and a.id_cabjari=b.id_cabjari
        where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
        and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
        and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where)a";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          $query .=" where (upper(a.nama_pemeriksa) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(a.nama_dimintai_keterangan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(a.keterangan) like'%".strtoupper($keyWord)."%')";
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

    public function searchBawas3terlapor(){
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $query="select a.* from was.was10 a where a.trx_akhir=1
        and a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
        and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
        and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";
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

    public function searchBawas3skasiint(){
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $query="select a.*,b.* from was.was9 a  inner join was.saksi_internal b 
                on a.id_tingkat = b.id_tingkat and
                    a.id_kejati  = b.id_kejati and
                    a.id_kejari  = b.id_kejari and
                    a.id_cabjari = b.id_cabjari and
                    a.id_saksi = b.id_saksi_internal and
                    a.jenis_saksi='Internal' and
                    a.id_wilayah=b.id_wilayah and
                    a.id_level1=b.id_level1 and
                    a.id_level2=b.id_level2 and 
                    a.id_level3=b.id_level3 and
                    a.id_level4=b.id_level4 and
					a.no_register=b.no_register
            where a.trx_akhir=1
                    and a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";
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

    public function searchBawas3skasieks(){
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $query="select a.*,b.* from was.was9 a  inner join was.saksi_eksternal b 
                on a.id_tingkat = b.id_tingkat and
                    a.id_kejati  = b.id_kejati and
                    a.id_kejari  = b.id_kejari and
                    a.id_cabjari = b.id_cabjari and
                    a.id_saksi = b.id_saksi_eksternal and
                    a.jenis_saksi='Eksternal' and
                    a.id_wilayah=b.id_wilayah and
                    a.id_level1=b.id_level1 and
                    a.id_level2=b.id_level2 and 
                    a.id_level3=b.id_level3 and
                    a.id_level4=b.id_level4 and 
					a.no_register=b.no_register
            where a.trx_akhir=1
                    and a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";
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
                ->from('was.v_ba_was_3_terlapor a')
				->innerJoin('was.ba_was_3 b on (a.id_ba_was_3=b.id_ba_was_3) ')
				->where("a.no_register= :no_register", [':no_register' => $params]);

        
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
                ->from('was.v_ba_was_3_saksi_internal a')
				->innerJoin('was.ba_was_3 b on (a.id_ba_was_3=b.id_ba_was_3) ')
				->where("a.no_register= :no_register", [':no_register' => $params]);

        
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
                ->from('was.v_ba_was_3_saksi_eksternal a')
				->innerJoin('was.ba_was_3 b on (a.id_ba_was_3=b.id_ba_was_3) ')
				->where("a.no_register= :no_register", [':no_register' => $params]);

        
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
