<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\SumberPengaduan;

/**
 * SumberPengaduanSearch represents the model behind the search form about `app\models\SumberPengaduan`.
 */
class SumberPengaduanSearch extends SumberPengaduan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_sumber_pengaduan', 'is_deleted', 'created_by', 'updated_by'], 'integer'],
            [['nm_sumber_pengaduan', 'keterangan', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
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
        $query = SumberPengaduan::find();

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
            'id_sumber_pengaduan' => $this->id_sumber_pengaduan,
            'is_deleted' => $this->is_deleted,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'nm_sumber_pengaduan', $this->nm_sumber_pengaduan])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
