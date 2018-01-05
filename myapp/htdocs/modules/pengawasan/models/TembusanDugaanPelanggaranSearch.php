<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\TembusanDugaanPelanggaran;

/**
 * TembusanDugaanPelanggaranSearch represents the model behind the search form about `app\models\TembusanDugaanPelanggaran`.
 */
class TembusanDugaanPelanggaranSearch extends TembusanDugaanPelanggaran
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tembusan_dugaan_pelanggaran', 'id_register', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['id_pejabat_tembusan', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
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
        $query = TembusanDugaanPelanggaran::find();

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
            'id_pejabat_tembusan' => $this->id_pejabat_tembusan,
            'is_deleted' => $this->is_deleted,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_tembusan_dugaan_pelanggaran', $this->id_tembusan_dugaan_pelanggaran])
            ->andFilterWhere(['like', 'id_register', $this->id_register])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
