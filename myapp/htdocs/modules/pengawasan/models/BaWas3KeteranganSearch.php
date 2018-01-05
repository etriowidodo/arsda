<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\BaWas3Keterangan;

/**
 * BaWas3KeteranganSearch represents the model behind the search form about `app\modules\pengawasan\models\BaWas3Keterangan`.
 */
class BaWas3KeteranganSearch extends BaWas3Keterangan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba_was_3_keterangan', 'id_ba_was_3', 'jawaban', 'upload_file', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['pertanyaan', 'created_by', 'updated_by'], 'integer'],
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
        $query = BaWas3Keterangan::find();

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
            'pertanyaan' => $this->pertanyaan,
            'flag' => $this->flag,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_ba_was_3_keterangan', $this->id_ba_was_3_keterangan])
            ->andFilterWhere(['like', 'id_ba_was_3', $this->id_ba_was_3])
            ->andFilterWhere(['like', 'jawaban', $this->jawaban])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
