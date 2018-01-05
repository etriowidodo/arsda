<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidsus\models\ParameterDetail;

/**
 * ParameterDetailSearch represents the model behind the search form about `app\models\ParameterDetail`.
 */
class ParameterDetailSearch extends ParameterDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_detail', 'id_header', 'no_urut'], 'integer'],
            [['nama_detail', 'nama_lain', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
        $query = ParameterDetail::find();

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
            'id_detail' => $this->id_detail,
            'id_header' => $this->id_header,
            'no_urut' => $this->no_urut,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['like', 'nama_detail', $this->nama_detail])
            ->andFilterWhere(['like', 'nama_lain', $this->nama_lain])
            ->andFilterWhere(['like', 'create_by', $this->create_by])
            ->andFilterWhere(['like', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
