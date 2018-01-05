<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Kejagungbidang;

/**
 * KejagungbidangSearch represents the model behind the search form about `app\models\Kejagungbidang`.
 */
class KejagungbidangSearch extends Kejagungbidang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_kejagung_bidang', 'nama_kejagung_bidang'], 'safe'],
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
        $query = Kejagungbidang::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id_kejagung_bidang', $this->id_kejagung_bidang])
            ->andFilterWhere(['like', 'nama_kejagung_bidang', $this->nama_kejagung_bidang]);

        return $dataProvider;
    }
}
