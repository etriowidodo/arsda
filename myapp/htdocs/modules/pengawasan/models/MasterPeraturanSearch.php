<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\MasterPeraturan;
use yii\data\SqlDataProvider;

/**
 * MasterPeraturanSearch represents the model behind the search form about `app\modules\pengawasan\models\MasterPeraturan`.
 */
class MasterPeraturanSearch extends MasterPeraturan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_peraturan', 'created_by', 'updated_by'], 'integer'],
            [['isi_peraturan', 'tgl_perja', 'kode_surat', 'pasal', 'tgl_inactive', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
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
        $query = MasterPeraturan::find();

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
            'id_peraturan' => $this->id_peraturan,
            'tgl_perja' => $this->tgl_perja,
            'tgl_inactive' => $this->tgl_inactive,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'isi_peraturan', $this->isi_peraturan])
            ->andFilterWhere(['like', 'kode_surat', $this->kode_surat])
            ->andFilterWhere(['like', 'pasal', $this->pasal])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }

    public function searchPeraturan($params)
    {
        $query="select*from was.ms_peraturan";
        $keyWord  = htmlspecialchars($_GET['cari_peraturan'], ENT_QUOTES);
         if($_GET['cari_peraturan']!=''){
          $query .=" where  (upper(id_peraturan) like'%".strtoupper($keyWord)."%'"; 
          $query .=" or  upper(nama_peraturan) like'%".strtoupper($keyWord)."%')"; 
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
