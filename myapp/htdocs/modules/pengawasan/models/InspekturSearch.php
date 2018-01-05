<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\Inspektur;

/**
 * InspekturSearch represents the model behind the search form about `app\models\Inspektur`.
 */
class InspekturSearch extends Inspektur
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_inspektur', 'nama_inspektur', 'bidang_inspektur', 'kode_surat', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['is_deleted', 'created_by', 'updated_by'], 'integer'],
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
        $query = Inspektur::find();

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
            'is_deleted' => $this->is_deleted,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_inspektur', $this->id_inspektur])
            ->andFilterWhere(['like', 'nama_inspektur', $this->nama_inspektur])
            ->andFilterWhere(['like', 'bidang_inspektur', $this->bidang_inspektur])
            ->andFilterWhere(['like', 'kode_surat', $this->kode_surat])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
