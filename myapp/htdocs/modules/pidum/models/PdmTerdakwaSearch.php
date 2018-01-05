<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmTerdakwa;

/**
 * PdmTerdakwaSearch represents the model behind the search form about `app\modules\pidum\models\PdmTerdakwa`.
 */
class PdmTerdakwaSearch extends PdmTerdakwa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tersangka', 'id_ba15'], 'safe'],
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
        $query = PdmTerdakwa::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'id_ba15', $this->id_ba15]);

        return $dataProvider;
    }
}
