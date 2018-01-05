<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Cabjari;

/**
 * CabjariSearch represents the model behind the search form about `app\models\Cabjari`.
 */
class CabjariSearch extends Cabjari
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_cabjari', 'nama_cabjari','id_kejati','id_kejari', 'akronim', 'inst_lokinst','inst_alamat'], 'safe'],
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
        $query = Cabjari::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->andWhere(['<>', 'id_cabjari', '-1']);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari])
            ->andFilterWhere(['like', 'nama_cabjari', $this->nama_cabjari])
            ->andFilterWhere(['like', 'akronim', $this->akronim])
            ->andFilterWhere(['like', 'inst_lokinst', $this->inst_lokinst])
            ->andFilterWhere(['like', 'inst_alamat', $this->inst_alamat]);

        return $dataProvider;
    }
}
