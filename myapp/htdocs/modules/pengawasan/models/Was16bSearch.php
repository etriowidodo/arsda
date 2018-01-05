<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was16b;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;


class Was16bSearch extends Was16b
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_was_16b', 'no_was_16b', 'tgl_was_16b', 'perihal',  'upload_file', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['kpd_was_16b', 'sifat_surat',  'created_by', 'updated_by'], 'integer'],
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
        $query="select*from was.was_16b a inner join was.ms_sk b on a.sk=b.kode_sk 
         where a.no_register='".$_SESSION['was_register']."'  and a.id_tingkat='".$_SESSION['kode_tk']."' 
        and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
        and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."'";
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

    public function searchold($params)
    {
        $query = Was16b::find();

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
            'kpd_was_16b' => $this->kpd_was_16b,
            'tgl_was_16b' => $this->tgl_was_16b,
            'sifat_surat' => $this->sifat_surat,
         //   'jml_lampiran' => $this->jml_lampiran,
         //   'satuan_lampiran' => $this->satuan_lampiran,
         //   'ttd_was_16b' => $this->ttd_was_16b,
         //   'flag' => $this->flag,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_was_16b', $this->id_was_16b])
            ->andFilterWhere(['like', 'no_was_16b', $this->no_was_16b])
            //->andFilterWhere(['like', 'id_register', $this->id_register])
           // ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
            ->andFilterWhere(['like', 'id_terlapor', $this->id_terlapor])
            ->andFilterWhere(['like', 'perihal', $this->perihal])
            // ->andFilterWhere(['like', 'perja', $this->perja])
            // ->andFilterWhere(['like', 'ttd_peg_nik', $this->ttd_peg_nik])
            // ->andFilterWhere(['like', 'ttd_id_jabatan', $this->ttd_id_jabatan])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }

     public function searchTerlapor($params)
    {
        /*saran jamwas sk pemberhentian tidak hormat*/
        $query="select distinct a.*, b.bentuk_pelanggaran from was.was_15_rencana a 
              inner join was.l_was_2_terlapor b on 
              a.nip_terlapor=a.nip_terlapor and 
              a.no_register=b.no_register and
              a.id_kejati=b.id_kejati and
              a.id_kejari=b.id_kejari and
              a.id_cabjari=b.id_cabjari and
              a.id_wilayah=b.id_wilayah and
              a.id_level1=b.id_level1 and
              a.id_level2=b.id_level2 and
              a.id_level3=b.id_level3 and
              a.id_level4=b.id_level4
 where a.saran_dari='Jamwas' and a.sk in('SK-WAS4-E','SK-WAS4-D') and a.no_register='".$_SESSION['was_register']."'  and a.id_tingkat='".$_SESSION['kode_tk']."' 
        and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
        and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."'";
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
        $query="select*from was.v_penandatangan where id_surat='was16b'";
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
//$id_register
    public function searchDataWas16b(){
        $query = new Query;
        $query ->select('a.peg_nama,a.peg_nip_baru, a.jabatan, c.no_was_16b,c.id_was_16b')
                ->from('was.v_riwayat_jabatan a')
                 ->innerjoin('was.terlapor b','a.id=b.id_h_jabatan')
                 ->innerjoin('was.was_16b c','b.id_terlapor=c.id_terlapor')
                 //->where(['c.id_register' =>$id_register])
                 ->Where(['c.flag'=>'1'])
                 ->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            return $dataProvider;
        }
        return $dataProvider;     
    }
}
