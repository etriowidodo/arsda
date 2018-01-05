<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was19b;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;

/**
 * Was19bSearch represents the model behind the search form about `app\modules\pengawasan\models\Was19b`.
 */
class Was19bSearch extends Was19b
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_was_19b', 'created_time', 'updated_time',
              'id_tingkat','id_kejati', 'id_kejari', 'id_cabjari','no_register','dari_was_19b',
              'no_was_19b', 'golongan_pegawai_terlapor','lampiran', 'pangkat_pegawai_terlapor', 'pangkat_penandatangan',
	          'perihal', 'nama_pegawai_terlapor', 'jabatan_pegawai_terlapor', 'nama_penandatangan',
	          'id_terlapor','nip_pegawai_terlapor', 'nip_penandatangan', 'created_ip', 'updated_ip',
	          'nrp_pegawai_terlapor','satker_pegawai_terlapor', 'jabatan_penandatangan',
	          'golongan_penandatangan','upload_file', 'kpd_was_19b'
              ], 'safe'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'id_was_19b',  'sifat_surat', 'created_by', 'updated_by'], 'integer'],
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
        $query = Was19b::find();

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
            'tgl_was_19b' => $this->tgl_was_19b,
            'sifat_surat' => $this->sifat_surat,
            'jml_lampiran' => $this->jml_lampiran,
            'satuan_lampiran' => $this->satuan_lampiran,
            'kpd_was_19b' => $this->kpd_was_19b,
            'ttd_was_19b' => $this->ttd_was_19b,
            'ttd_id_jabatan' => $this->ttd_id_jabatan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_was_19b', $this->id_was_19b])
            ->andFilterWhere(['like', 'no_was_19b', $this->no_was_19b])
            ->andFilterWhere(['like', 'id_register', $this->id_register])
            ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
            ->andFilterWhere(['like', 'id_terlapor', $this->id_terlapor])
            ->andFilterWhere(['like', 'ttd_peg_nik', $this->ttd_peg_nik])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }

    public function searchTerlapor($params)
    {
        /*saran_l_was_2=1 adalah yang dilanjutkan*/
        $query="select a.*,b.*,c.* from was.ba_was_5 a 
                inner join was.ms_sk b
                on a.sk=b.kode_sk
                inner join was.l_was_2_terlapor c
                on a.id_tingkat=c.id_tingkat and
                a.id_kejati=c.id_kejati and
                a.id_kejari=c.id_kejari and
                a.id_cabjari=c.id_cabjari and 
                a.no_register=c.no_register and
                a.nip_penerima=c.nip_terlapor where 
        		    a.id_tingkat::text = '".$_SESSION['kode_tk']."' AND a.id_kejati::text ='".$_SESSION['kode_kejati']."'  
                AND a.id_kejari::text ='".$_SESSION['kode_kejari']."' AND a.id_cabjari::text ='".$_SESSION['kode_cabjari']."'  
                AND a.no_register::text ='".$_SESSION['was_register']."' AND a.id_wilayah::text = '".$_SESSION['was_id_wilayah']."' 
                AND a.id_level1::text ='".$_SESSION['was_id_level1']."'  AND a.id_level2::text ='".$_SESSION['was_id_level2']."' 
                AND a.id_level3::text ='".$_SESSION['was_id_level3']."' AND a.id_level4::text ='".$_SESSION['was_id_level4']."'  ";
       //print_r($query);         
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
    
     public function searchIndex($params)
     {
         $query="select b.* from was.was_19b b
                where b.no_register='".$_SESSION['was_register']."' and b.id_tingkat='".$_SESSION['kode_tk']."' 
                and b.id_kejati='".$_SESSION['kode_kejati']."' and b.id_kejari='".$_SESSION['kode_kejari']."' 
                and b.id_cabjari='".$_SESSION['kode_cabjari']."'and b.id_wilayah='".$_SESSION['was_id_wilayah']."' 
                and b.id_level1='".$_SESSION['was_id_level1']."' and b.id_level2='".$_SESSION['was_id_level2']."' 
                and b.id_level3='".$_SESSION['was_id_level3']."' and b.id_level4='".$_SESSION['was_id_level4']."' ";
        // print_r($query);
        // exit();
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

     public function searchPenandatangan($params)
    {
        $query="select*from was.v_penandatangan where id_surat='Skwas2a' and unitkerja_alias='".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."'";
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
