<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\MsPenyidik;

/**
 * MsPenyidikSearch represents the model behind the search form about `app\modules\pidum\models\MsPenyidik`.
 */
class MsPenyidikSearch extends MsPenyidik
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_penyidik', 'nama'], 'safe'],
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
        $query = MsPenyidik::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
              
        $query->andFilterWhere(['like', 'id_penyidik', $this->id_penyidik])
            ->andFilterWhere(['like', 'nama', $this->nama]);

        return $dataProvider;
    }
}
