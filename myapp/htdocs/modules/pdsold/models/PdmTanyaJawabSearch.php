<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmTanyaJawab;

/**
 * PdmTanyaJawabSearch represents the model behind the search form about `app\modules\pidum\models\PdmTanyaJawab`.
 */
class PdmTanyaJawabSearch extends PdmTanyaJawab
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'kode_table', 'id_table', 'pertanyaan', 'jawaban', 'flag'], 'safe'],
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
        $query = PdmTanyaJawab::find();

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
            ->andFilterWhere(['like', 'kode_table', $this->kode_table])
            ->andFilterWhere(['like', 'id_table', $this->id_table])
            ->andFilterWhere(['like', 'pertanyaan', $this->pertanyaan])
            ->andFilterWhere(['like', 'jawaban', $this->jawaban])
            ->andFilterWhere(['like', 'flag', $this->flag]);

        return $dataProvider;
    }
}
