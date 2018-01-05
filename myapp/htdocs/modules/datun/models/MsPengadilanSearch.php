<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\datun\models\MsPengadilan;

/**
 * MsWilayahSearch represents the model behind the search form about `app\modules\datun\models\MsWilayah`.
 */
class MsPengadilanSearch extends MsPengadilan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode', 'deskripsi'], 'safe'],
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
        $query = MsPengadilan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'upper(kode)', strtoupper($this->kode)])
            ->andFilterWhere(['like', 'upper(deskripsi)', strtoupper($this->deskripsi)]);

        return $dataProvider;
    }
}
