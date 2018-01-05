<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Kejati;

/**
 * KejagungbidangSearch represents the model behind the search form about `app\models\Kejagungbidang`.
 */
class KejatiSearch extends Kejati
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_kejati', 'nama_kejati'], 'safe'],
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
        $query = Kejati::findBySql("select*from was.kejati where id_kejati !='-1'");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->andWhere(['!=', 'id_kejati', '-1']);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');

            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id_kejati', $this->id_kejati])
            ->andFilterWhere(['like', 'nama_kejati', $this->nama_kejati]);

        return $dataProvider;
    }
}
