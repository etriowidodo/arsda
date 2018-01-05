<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmConfig;

/**
 * PdmConfigSearch represents the model behind the search form about `app\modules\pidum\models\PdmConfig`.
 */
class PdmConfigSearch extends PdmConfig
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kd_satker', 'time_format', 'flag'], 'safe'],
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
        $query = PdmConfig::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'kd_satker', $this->kd_satker])
            ->andFilterWhere(['like', 'time_format', $this->time_format])
            ->andFilterWhere(['like', 'flag', $this->flag]);

        return $dataProvider;
    }
}
