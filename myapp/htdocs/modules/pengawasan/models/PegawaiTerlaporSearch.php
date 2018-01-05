<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PegawaiTerlapor;

/**
 * TerlaporSearch represents the model behind the search form about `app\models\Terlapor`.
 */
class PegawaiTerlaporSearch extends PegawaiTerlapor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pegawai_terlapor'], 'string'],
            [['nip', 'nrp_pegawai_terlapor', 'nama_pegawai_terlapor', 'pangkat_pegawai_terlapor', 'golongan_pegawai_terlapor', 'jabatan_pegawai_terlapor', 'satker_pegawai_terlapor', 'nomor_sp_was1', 'no_register', 'for_tabel'], 'safe'],
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
        $query = PegawaiTerlapor::find();

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
