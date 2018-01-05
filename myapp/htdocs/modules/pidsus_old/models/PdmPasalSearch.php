<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidsus\models\PdmPasal;

/**
 * PdmPasalSearch represents the model behind the search form about `app\models\PdmPasal`.
 */
class PdmPasalSearch extends PdmPasal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_tersangka'], 'integer'],
            [['pasal', 'disangkakan', 'didakwakan', 'terbukti'], 'safe'],
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
        $query = PdmPasal::find();

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
            'id' => $this->id,
            'id_tersangka' => $this->id_tersangka,
        ]);

        $query->andFilterWhere(['like', 'pasal', $this->pasal])
            ->andFilterWhere(['like', 'disangkakan', $this->disangkakan])
            ->andFilterWhere(['like', 'didakwakan', $this->didakwakan])
            ->andFilterWhere(['like', 'terbukti', $this->terbukti]);

        return $dataProvider;
    }
}
