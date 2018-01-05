<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Irmud;

/**
 * InspekturModelSearch represents the model behind the search form about `app\modules\pengawasan\models\InspekturModel`.
 */
class IrmudSearch extends Irmud
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_irmud'], 'integer'],
            [['nama_irmud', 'akronim', 'kode_surat', 'id_inspektur'], 'safe'],

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
        $query = Irmud::find();

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
            'id_irmud' => $this->id_irmud,
            'akronim' => $this->akronim,
        ]);

        $query->andFilterWhere(['like', 'nama_irmud', $this->nama_irmud])
            ->andFilterWhere(['like', 'akronim', $this->akronim]);

        return $dataProvider;
    }
}
