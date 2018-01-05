<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\LWas2Inspeksi;
use app\modules\pengawasan\components\FungsiComponent;
use yii\data\SqlDataProvider; 
use yii\db\Query;

/**
 * LWas2Search represents the model behind the search form about `app\modules\pengawasan\models\LWas2`.
 */
class LWas2InspeksiSearch extends LWas2Inspeksi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_l_was_2', 'id_register', 'inst_satkerkd', 'tgl', 'upload_file', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['flag', 'created_by', 'updated_by'], 'integer'],
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
        $query = LWas2Inspeksi::find();

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
            'flag' => $this->flag,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_l_was_2', $this->id_l_was_2])
            ->andFilterWhere(['like', 'id_register', $this->id_register])
            ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
    
    
     public function searchPenandatangan($params)
    {
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');    
        $query="select a.* from was.pemeriksa_sp_was2 a 
                where a.no_register='".$_SESSION['was_register']."'  
                and a.id_tingkat='".$_SESSION['kode_tk']."' 
                and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";
        $keyWord  = htmlspecialchars($_GET['cari_penandatangan'], ENT_QUOTES);
         if($_GET['cari_penandatangan']!=''){
          $query .=" and  upper(nama_pemeriksa) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(nip_pemeriksa) ='".($keyWord)."'";
          $query .=" or  upper(jabatan_pemeriksa) like'%".strtoupper($keyWord)."%'";
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

        // if (!$this->validate()) {

        //     return $dataProvider;
        // }
        
        return $dataProvider;
    }
    
   
}
