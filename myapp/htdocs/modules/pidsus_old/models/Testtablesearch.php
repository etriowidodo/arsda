<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidsus\models\Testtable;

/**
 * Testtablesearch represents the model behind the search form about `app\models\Testtable`.
 */
class Testtablesearch extends Testtable
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Id'], 'integer'],
            [['data1', 'data2'], 'safe'],
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
        $query = Testtable::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'Id' => $this->Id,
        ]);

        $query->andFilterWhere(['like', 'data1', $this->data1])
            ->andFilterWhere(['like', 'data2', $this->data2]);

        return $dataProvider;
    }
}
