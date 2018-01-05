<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\MsPeraturan;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;

/**
 * MsPeraturanSearch represents the model behind the search form about `app\modules\pengawasan\models\MsPeraturan`.
 */
class MsPeraturanSearch extends MsPeraturan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_peraturan', 'nama_peraturan'], 'safe'],
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
        $query = MsPeraturan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id_peraturan', $this->id_peraturan])
            ->andFilterWhere(['like', 'nama_peraturan', $this->nama_peraturan]);

        return $dataProvider;
    }

    public function searchIndex($params)
    { 
        $query="select*from was.ms_peraturan";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          $query .=" where (upper(nama_peraturan) like'%".strtoupper($keyWord)."%'"; 
          $query .=" or  upper(id_peraturan) like'%".strtoupper($keyWord)."%')";
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
