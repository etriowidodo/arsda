<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\LWas1;
use app\modules\pengawasan\components\FungsiComponent;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;
/**
 * LWas1Search represents the model behind the search form about `app\modules\pengawasan\models\LWas1`.
 */
class LWas1Search extends LWas1
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_l_was_1', 'no_register', 'data_lwas1', 'analis_lwas1','permasalahan_lwas1','pendapat'], 'safe'],
            // [['created_by', 'updated_by'], 'integer'],
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
        $query = LWas1::find();

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
        //     'tgl' => $this->tgl,
        //     'flag' => $this->flag,
        //     'created_by' => $this->created_by,
        //     'created_time' => $this->created_time,
        //     'updated_by' => $this->updated_by,
        //     'updated_time' => $this->updated_time,
        // ]);

        // $query->andFilterWhere(['like', 'id_l_was_1', $this->id_l_was_1])
        //     ->andFilterWhere(['like', 'no_register', $this->no_register])
        //     ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
        //     ->andFilterWhere(['like', 'data_data', $this->data_data])
        //     ->andFilterWhere(['like', 'upload_file_data', $this->upload_file_data])
        //     ->andFilterWhere(['like', 'analisa', $this->analisa])
        //     ->andFilterWhere(['like', 'upload_file', $this->upload_file])
        //     ->andFilterWhere(['like', 'created_ip', $this->created_ip])
        //     ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
	
	public function searchTerlaorWas10($no_register){
        $fungsi=new FungsiComponent();
        $where =$fungsi->static_where();
        $query="select*from was.pegawai_terlapor_was10 where no_register='".$no_register."' and id_tingkat='".$_SESSION['kode_tk']."' 
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

    public function searchLwas1Saran($no_register){
        $fungsi=new FungsiComponent();
        $where =$fungsi->static_where_alias('a');
        $query="select a.nip_terlapor as nip,a.nrp_terlapor as nrp_pegawai_terlapor,a.nama_terlapor as nama_pegawai_terlapor,a.pangkat_terlapor as pangkat_pegawai_terlapor,a.golongan_terlapor as golongan_pegawai_terlapor,a.jabatan_terlapor as jabatan_pegawai_terlapor,
                case  when saran_lwas1='1' then
                'Tidak Ditindak Lanjuti'
                WHEN saran_lwas1='2' then
                'Ditindak Lanjuti'
                ELSE
                '-'
                end as saran
                from was.l_was_1_saran a where a.no_register='".$no_register."' and 
        a.id_tingkat='".$_SESSION['kode_tk']."' 
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
	
	public function searchSaksiInternalLwas1($no_register){
        $query = new Query;
		$query->select('a.*')
                ->from('was.v_riwayat_jabatan a')
                ->innerJoin('was.saksi_internal b on (a.id=b.id_h_jabatan)')
                ->where(['b.id_register' => $no_register]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!$this->validate()) {
            return $dataProvider;
        }
        return $dataProvider;
    }

	public function searchSaksiEksternalLwas1($no_register){
        $query = new Query;
		$query->select('nama,alamat')
                ->from('was.saksi_eksternal ')
                ->where(['no_register' => $no_register]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!$this->validate()) {
            return $dataProvider;
        }
        return $dataProvider;
    }
	
	public function searchTerlapor($no_register){
        $query = new Query;
        $query->select('a.*, b.id_terlapor ')
                ->from('was.v_riwayat_jabatan a')
                ->innerJoin('was.terlapor b on (a.id=b.id_h_jabatan)')
                //->where('a.no_register = :idRegister')
                ->where(['b.id_register' => $no_register]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!$this->validate()) {
            return $dataProvider;
        }
        return $dataProvider;
    }
}
