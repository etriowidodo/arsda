<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\TembusanMaster;

/**
 * InspekturModelSearch represents the model behind the search form about `app\modules\pengawasan\models\InspekturModel`.
 */
class TembusanMasterSearch extends TembusanMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tembusan'], 'string'],
            [['nama_tembusan'], 'string', 'max' => 65],
            [['for_tabel'], 'string', 'max' => 20],
            [['kode_wilayah'], 'string', 'max' => 2]
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
        $query = TembusanMaster::find();

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
            'id_tembusan' => $this->id_tembusan,
            'nama_tembusan' => $this->nama_tembusan,
            'for_tabel' => $this->for_tabel,
            'kode_wilayah' => $this->kode_wilayah,
        ]);

        $query->andFilterWhere(['like', 'nama_tembusan', $this->nama_tembusan])
            ->andFilterWhere(['like', 'for_tabel', $this->for_tabel]);

        return $dataProvider;
    }
}
