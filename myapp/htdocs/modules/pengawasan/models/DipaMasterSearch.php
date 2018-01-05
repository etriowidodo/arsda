<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\DipaMaster;
use yii\db\Query;

/**
 * InspekturModelSearch represents the model behind the search form about `app\modules\pengawasan\models\InspekturModel`.
 */
class DipaMasterSearch extends DipaMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_dipa'], 'string'],
            [['dipa', 'tahun', 'is_aktif'], 'safe'],
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
        $query = DipaMaster::find();

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
            'id_dipa' => $this->id_dipa,
            'dipa' => $this->dipa,
            'tahun' => $this->tahun,
            'is_aktif' => $this->is_aktif,
        ]);

        $query->andFilterWhere(['like', 'dipa', $this->dipa])
            ->andFilterWhere(['like', 'tahun', $this->tahun]);

        return $dataProvider;
    }

    
}
