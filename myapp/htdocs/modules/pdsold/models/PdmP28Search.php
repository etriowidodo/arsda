<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmP28;

/**
 * PdmP28Search represents the model behind the search form about `app\modules\pidum\models\PdmP28`.
 */
class PdmP28Search extends PdmP28
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p28', 'id_perkara', 'no_surat', 'hakim1', 'hakim2', 'hakim3', 'panitera', 'penasehat'], 'safe'],
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
        $query = PdmP28::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        
        $query->andFilterWhere(['like', 'id_p28', $this->id_p28])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'hakim1', $this->hakim1])
            ->andFilterWhere(['like', 'hakim2', $this->hakim2])
            ->andFilterWhere(['like', 'hakim3', $this->hakim3])
            ->andFilterWhere(['like', 'panitera', $this->panitera])
            ->andFilterWhere(['like', 'penasehat', $this->penasehat]);

        return $dataProvider;
    }
}
