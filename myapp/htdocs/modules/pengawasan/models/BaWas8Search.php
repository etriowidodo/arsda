<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\modules\pengawasan\models\BaWas8;
use yii\db\Query;

/**
 * BaWas8Search represents the model behind the search form about `app\modules\pengawasan\models\BaWas8`.
 */
class BaWas8Search extends BaWas8
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_ba_was_8', 'created_time', 'updated_time','id_tingkat','id_kejati', 'id_kejari', 'id_cabjari','no_register','tempat', 'nama_terlapor', 'nama_menerima',
			'id_terlapor','nip_terlapor', 'nip_menerima', 'created_ip', 'updated_ip','nrp_terlapor', 'nrp_menerima','pangkat_terlapor', 'pangkat_menerima','golongan_terlapor', 'golongan_menerima',
			'jabatan_terlapor', 'jabatan_menerima','upload_file'], 'safe'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_ba_was_8', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'terima_tolak', 'created_by', 'updated_by'], 'integer'],
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
        $query = BaWas8::find();

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
            'tgl_ba_was_8' => $this->tgl_ba_was_8,
            'terima_tolak' => $this->terima_tolak,
            'ttd_id_jabatan' => $this->ttd_id_jabatan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_ba_was_8', $this->id_ba_was_8])
            ->andFilterWhere(['like', 'no_ba_was_8', $this->no_ba_was_8])
            ->andFilterWhere(['like', 'id_register', $this->id_register])
            ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
            ->andFilterWhere(['like', 'tempat', $this->tempat])
            ->andFilterWhere(['like', 'id_terlapor', $this->id_terlapor])
            ->andFilterWhere(['like', 'ttd_peg_nik', $this->ttd_peg_nik])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
	
	public function searchTerlapor(){
		$noreg 		= $_SESSION['was_register'];
		$id_tingkat = $_SESSION['kode_tk'];
		$id_kejati 	= $_SESSION['kode_kejati']; 
		$id_kejari 	= $_SESSION['kode_kejari']; 
		$id_cabjari = $_SESSION['kode_cabjari']; 
		//and id_kejari = '".$_SESSION['kode_kejari']."' and id_cabjari = '".$_SESSION['kode_cabjari'].'
		$query="select*from was.ba_was_7 a inner join was.ms_sk b on a.sk=b.kode_sk 
        inner join kepegawaian.kp_pegawai c on a.nip_terlapor=c.peg_nip_baru
        where no_register = '$noreg' and id_tingkat='$id_tingkat' and id_kejati='$id_kejati' and id_kejari='$id_kejari' and id_cabjari='$id_cabjari'  and c.pns_jnsjbtfungsi='0'";
        $keyWord  = htmlspecialchars($_GET['cari_terlapor'], ENT_QUOTES);
			if($_GET['cari_penandatangan']!=''){ 
			$query .=" and  upper(nama_terlapor) like'%".strtoupper($keyWord)."%'";
			$query .=" or  upper(nip_terlapor) ='".($keyWord)."'";
			$query .=" or  upper(nrp_terlapor) like'%".strtoupper($keyWord)."%'";
			$query .=" or  upper(jabatan_terlapor) like'%".strtoupper($keyWord)."%'";
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
	
	public function searchPenerima(){
		$query="select * from kepegawaian.kp_pegawai where inst_satkerkd='00'";
        $keyWord  = htmlspecialchars($_GET['cari_penerima'], ENT_QUOTES);
			if($_GET['cari_penerima']!=''){
			$query .=" and  upper(nama) like'%".strtoupper($keyWord)."%'";
			$query .=" or  upper(peg_nip_baru) ='".($keyWord)."'";
			$query .=" or  upper(peg_nrp) like'%".strtoupper($keyWord)."%'";
			$query .=" or  upper(jabatan) like'%".strtoupper($keyWord)."%'";
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
	
	public function searchBawas8(){
		$query="select * from was.ba_was_8 where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
        and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
        $keyWord  = htmlspecialchars($_GET['cari_penerima'], ENT_QUOTES);
			if($_GET['cari_penerima']!=''){
			$query .=" where  upper(nama_terlapor) like'%".strtoupper($keyWord)."%'"; 
			$query .=" or  upper(terima_tolak) like'%".strtoupper($keyWord)."%'";
			$query .=" or  upper(nama_menerima) like'%".strtoupper($keyWord)."%'";
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
	
	
	public function searchBawas6($params)
    {
		
		$query = new Query;
        $query->select('a.peg_nama, a.peg_nip, a.jabatan, c.id_ba_was_8')
                ->from('was.v_terlapor a')
				->innerJoin('was.ba_was_8 c on (a.id_terlapor=c.id_terlapor) ')
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
	
}
