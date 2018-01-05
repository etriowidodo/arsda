<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\MsPasal;

/**
 * MsPasalSearch represents the model behind the search form about `app\modules\pidum\models\MsPasal`.
 */
class MsPasalSearch extends MsPasal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uu', 'pasal', 'bunyi'], 'safe'],
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
		
        $query = MsPasal::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
		//var_dump($params);exit;
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
		
		if($params['MsPasalSearch']['uu']!=''){
			$query->andFilterWhere(['like', 'upper(uu)', strtoupper($params['MsPasalSearch']['uu'])]);
		}
		//dari pop up pedoman
		if($params['MsPasal']['uu']!=''){
			$query->andFilterWhere(['like', 'upper(uu)', strtoupper($params['MsPasal']['uu'])]);
		}
		
		if($params['MsPasalSearch']['pasal']!=''){
			$query->andFilterWhere(['like', 'upper(pasal)', strtoupper($params['MsPasalSearch']['pasal'])]);
		}
        if($params['MsPasalSearch']['bunyi']!=''){
			$query->andFilterWhere(['like', 'upper(bunyi)', strtoupper($params['MsPasalSearch']['bunyi'])]);
		}

        return $dataProvider;
    }
}
