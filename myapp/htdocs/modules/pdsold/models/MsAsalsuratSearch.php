<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\MsAsalsurat;

/**
 * MsAsalsuratSearch represents the model behind the search form about `app\modules\pidum\models\MsAsalsurat`.
 */
class MsAsalsuratSearch extends MsAsalsurat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_asalsurat', 'nama'], 'safe'],
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
        $query = MsAsalsurat::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
		$query->andWhere(['!=', 'flag', '3']);

        $query->andFilterWhere(['like', 'id_asalsurat', $this->id_asalsurat])
            ->andFilterWhere(['like', 'nama', $this->nama]);

        return $dataProvider;
    }
}
