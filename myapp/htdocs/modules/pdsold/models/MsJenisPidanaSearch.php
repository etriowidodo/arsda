<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\MsJenisPidana;

/**
 * MsJenisPidanaSearch represents the model behind the search form about `app\modules\pidum\models\MsJenisPidana`.
 */
class MsJenisPidanaSearch extends MsJenisPidana
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_pidana'], 'integer'],
            [['nama', 'akronim'], 'safe'],
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
        $query = MsJenisPidana::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'kode_pidana' => $this->kode_pidana,
        ]);

        $query->andFilterWhere(['like', 'upper(nama)', strtoupper($this->nama)])
            ->andFilterWhere(['like', 'upper(akronim)', strtoupper($this->akronim)]);

        return $dataProvider;
    }
}
