<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\MasterSurat;
use yii\data\SqlDataProvider;

/**
 * MasterSuratSearch represents the model behind the search form about `app\modules\pengawasan\models\MasterSurat`.
 */
class MasterSuratSearch extends MasterSurat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_surat', 'keterangan'], 'safe'],
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
        $query = MasterSurat::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id_surat', $this->id_surat])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }

    public function searchSurat($params)
    {
        $query="select*from was.master_surat ";
        $keyWord  = htmlspecialchars($_GET['cari_surat'], ENT_QUOTES);
         if($_GET['cari_surat']!=''){
          $query .=" where  (upper(id_surat) like'%".strtoupper($keyWord)."%'"; 
          $query .=" or  upper(keterangan) like'%".strtoupper($keyWord)."%')"; 
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
        $query="select*from was.master_surat";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          $query .=" where (upper(keterangan) like'%".strtoupper($keyWord)."%'"; 
          $query .=" or  upper(id_surat) like'%".strtoupper($keyWord)."%')";
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
