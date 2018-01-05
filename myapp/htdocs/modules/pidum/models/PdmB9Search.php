<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmB9;

/**
 * PdmB9Search represents the model behind the search form about `app\modules\pidum\models\PdmB9`.
 */
class PdmB9Search extends PdmB9
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_b9', 'tgl_b9', 'putusan_negeri', 'tgl_pn', 'amar_pn', 'barbuk', 'putusan_tinggi', 'tgl_pt', 'amar_pt', 'no_ma', 'tgl_ma', 'amar_ma', 'id_kejati', 'id_kejari', 'id_cabjari', 'created_ip', 'created_time', 'updated_ip', 'updated_time', 'nip_jaksa', 'nip_petugas', 'nama_petugas'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
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
    public function search($no_register_perkara,$params)
    {
        $query = PdmB9::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->andWhere(['=', 'no_register_perkara', $no_register_perkara]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tgl_b9' => $this->tgl_b9,
            'tgl_pn' => $this->tgl_pn,
            'tgl_pt' => $this->tgl_pt,
            'tgl_ma' => $this->tgl_ma,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'no_surat_b9', $this->no_surat_b9])
            ->andFilterWhere(['like', 'putusan_negeri', $this->putusan_negeri])
            ->andFilterWhere(['like', 'amar_pn', $this->amar_pn])
            ->andFilterWhere(['like', 'barbuk', $this->barbuk])
            ->andFilterWhere(['like', 'putusan_tinggi', $this->putusan_tinggi])
            ->andFilterWhere(['like', 'amar_pt', $this->amar_pt])
            ->andFilterWhere(['like', 'no_ma', $this->no_ma])
            ->andFilterWhere(['like', 'amar_ma', $this->amar_ma])
            ->andFilterWhere(['like', 'id_kejati', $this->id_kejati])
            ->andFilterWhere(['like', 'id_kejari', $this->id_kejari])
            ->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip])
            ->andFilterWhere(['like', 'nip_jaksa', $this->nip_jaksa])
            ->andFilterWhere(['like', 'nip_petugas', $this->nip_petugas])
            ->andFilterWhere(['like', 'nama_petugas', $this->nama_petugas]);

        return $dataProvider;
    }
}
