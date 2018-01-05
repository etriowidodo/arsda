<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\BaWas4Detail;

/**
 * BaWas4DetailSearch represents the model behind the search form about `app\modules\pengawasan\models\BaWas4Detail`.
 */
class BaWas4DetailSearch extends BaWas4Detail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba_was_4_detail', 'id_ba_was_4', 'pernyataan'], 'safe'],
            //[['created_by', 'updated_by'], 'integer'],
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
        $query = BaWas4Detail::find();

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
            'flag' => $this->flag,
           /*  'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time, */
        ]);

        $query->andFilterWhere(['like', 'id_ba_was_4_detail', $this->id_ba_was_4_detail])
            ->andFilterWhere(['like', 'id_ba_was_4', $this->id_ba_was_4])
           /*  ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]) */
            ->andFilterWhere(['like', 'pernyataan', $this->pernyataan]);

        return $dataProvider;
    }
}
