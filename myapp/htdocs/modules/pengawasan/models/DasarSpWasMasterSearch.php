<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\DasarSpWasMaster;

/**
 * DasarSpWasMasterSearch represents the model behind the search form about `app\modules\pengawasan\models\DasarSpWasMaster`.
 */
class DasarSpWasMasterSearch extends DasarSpWasMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_dasar_spwas', 'isi_dasar_spwas', 'tahun'], 'safe'],
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
        $query = DasarSpWasMaster::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id_dasar_spwas', $this->id_dasar_spwas])
            ->andFilterWhere(['like', 'isi_dasar_spwas', $this->isi_dasar_spwas])
            ->andFilterWhere(['like', 'tahun', $this->tahun]);

        return $dataProvider;
    }
}
