<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\WasDisposisiInspektur;

/**
 * WasDisposisiInspekturSearch represents the model behind the search form about `app\modules\pengawasan\models\WasDisposisiInspektur`.
 */
class WasDisposisiInspekturSearch extends WasDisposisiInspektur
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_urut', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'id_inspektur', 'id_irmud', 'urut_terlapor', 'created_by'], 'integer'],
            [['id_tingkat', 'id_kejati', 'id_kejari', 'id_cabjari', 'no_register', 'tanggal_disposisi', 'isi_disposisi', 'file_inspektur', 'status', 'created_ip', 'created_time'], 'safe'],
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
        $query = WasDisposisiInspektur::find();

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
            'no_urut' => $this->no_urut,
            'id_wilayah' => $this->id_wilayah,
            'id_level1' => $this->id_level1,
            'id_level2' => $this->id_level2,
            'id_level3' => $this->id_level3,
            'id_level4' => $this->id_level4,
            'id_inspektur' => $this->id_inspektur,
            'tanggal_disposisi' => $this->tanggal_disposisi,
            'id_irmud' => $this->id_irmud,
            'urut_terlapor' => $this->urut_terlapor,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
        ]);

        $query->andFilterWhere(['like', 'id_tingkat', $this->id_tingkat])
            ->andFilterWhere(['like', 'id_kejati', $this->id_kejati])
            ->andFilterWhere(['like', 'id_kejari', $this->id_kejari])
            ->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari])
            ->andFilterWhere(['like', 'no_register', $this->no_register])
            ->andFilterWhere(['like', 'isi_disposisi', $this->isi_disposisi])
            ->andFilterWhere(['like', 'file_inspektur', $this->file_inspektur])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip]);

        return $dataProvider;
    }
}
