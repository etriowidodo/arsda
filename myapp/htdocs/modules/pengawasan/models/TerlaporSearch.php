<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Terlapor;

/**
 * TerlaporSearch represents the model behind the search form about `app\models\Terlapor`.
 */
class TerlaporSearch extends Terlapor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_terlapor_awal'], 'integer'],
            [['nama_terlapor_awal', 'jabatan_terlapor_awal', 'satker_terlapor_awal', 'pelanggaran_terlapor_awal', 'tgl_pelanggaran_terlapor_awal', 'bln_pelanggaran_terlapor_awal', 'thn_pelanggaran_terlapor_awal', 'no_register', 'id_wilayah', 'id_bidang_kejati', 'id_unit_kerja', 'id_cabjari','irmud_pegasum_kepbang','irmud_pidum_datun','irmud_intel_pidsus'], 'safe'],
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
        $query = Terlapor::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // $query->andFilterWhere([
        //     'id_terlapor_awal' => $this->id_terlapor_awal,
        // ]);

        // $query->andFilterWhere(['like', 'nama_terlapor_awal', $this->nama_terlapor_awal])
        //     ->andFilterWhere(['like', 'jabatan_terlapor_awal', $this->jabatan_terlapor_awal])
        //     ->andFilterWhere(['like', 'satker_terlapor_awal', $this->satker_terlapor_awal])
        //     ->andFilterWhere(['like', 'pelanggaran_terlapor_awal', $this->pelanggaran_terlapor_awal])
        //     ->andFilterWhere(['like', 'tgl_pelanggaran_terlapor_awal', $this->tgl_pelanggaran_terlapor_awal])
        //     ->andFilterWhere(['like', 'bln_pelanggaran_terlapor_awal', $this->bln_pelanggaran_terlapor_awal])
        //     ->andFilterWhere(['like', 'thn_pelanggaran_terlapor_awal', $this->thn_pelanggaran_terlapor_awal])
        //     ->andFilterWhere(['like', 'no_register', $this->no_register])
        //     ->andFilterWhere(['like', 'id_wilayah', $this->id_wilayah])
        //     ->andFilterWhere(['like', 'id_bidang_kejati', $this->id_bidang_kejati])
        //     ->andFilterWhere(['like', 'id_unit_kerja', $this->id_unit_kerja])
        //     ->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari]);

        return $dataProvider;
    }
}
