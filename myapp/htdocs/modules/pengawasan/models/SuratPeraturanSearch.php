<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\SuratPeraturan;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;

/**
 * SuratPeraturanSearch represents the model behind the search form about `app\modules\pengawasan\models\SuratPeraturan`.
 */
class SuratPeraturanSearch extends SuratPeraturan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_surat', 'id_peraturan'], 'safe'],
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
        $query = SuratPeraturan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'id_surat', $this->id_surat])
            ->andFilterWhere(['like', 'id_peraturan', $this->id_peraturan]);

        return $dataProvider;
    }

    public function searchIndex($params)
    { 
        $query="select*from was.surat_peraturan a inner join was.ms_peraturan b on a.id_peraturan=b.id_peraturan";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          $query .=" where (upper(a.id) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(a.id_surat) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(a.id_peraturan) like'%".strtoupper($keyWord)."%')";
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
