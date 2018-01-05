<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Kejagungunit;
use yii\db\Query;
/**
 * KejagungunitSearch represents the model behind the search form about `app\models\Kejagungunit`.
 */
class KejagungunitSearch extends Kejagungunit
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_kejagung_unit', 'nama_kejagung_unit', 'id_kejagung_bidang'], 'safe'],
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
        $query = Kejagungunit::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id_kejagung_unit', $this->id_kejagung_unit])
            ->andFilterWhere(['like', 'nama_kejagung_unit', $this->nama_kejagung_unit])
            ->andFilterWhere(['like', 'id_kejagung_bidang', $this->id_kejagung_bidang]);

        return $dataProvider;
    }

    public function searchbidang($params)
    {
        $query = new Query;
        $query->select('id_kejagung_unit,nama_kejagung_unit,id_kejagung_bidang')
                ->from('was.Kejagungunit a')
                ->where(['id_kejagung_bidang' => $params]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // $query->andFilterWhere(['like', 'id_kejagung_unit', $this->id_kejagung_unit])
        //     ->andFilterWhere(['like', 'nama_kejagung_unit', $this->nama_kejagung_unit])
        //     ->andFilterWhere(['like', 'id_kejagung_bidang', $this->id_kejagung_bidang]);

        return $dataProvider;
    }
}
