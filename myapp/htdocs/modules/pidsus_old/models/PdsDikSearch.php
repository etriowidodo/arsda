<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidsus\models\PdsDik;

/**
 * PdsDikSearch represents the model behind the search form about `app\modules\pidsus\models\PdsDik`.
 */
class PdsDikSearch extends PdsDik
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_dik', 'id_satker', 'tgl_diterima', 'penerima_spdp', 'asal_spdp', 'perihal_spdp', 'no_spdp', 'tgl_spdp', 'isi_spdp', 'uraian_spdp', 'penandatangan_lap', 'create_by', 'create_date', 'update_by', 'update_date', 'id_satker_parent', 'no_berkas_perkara', 'tgl_register_perkara', 'kasus_posisi', 'tgl_selesai', 'create_ip', 'update_ip', 'id_pds_lid_parent'], 'safe'],
            [['id_status', 'is_internal', 'jenis_kasus'], 'integer'],
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
        $query = PdsDik::find();

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
            'tgl_diterima' => $this->tgl_diterima,
            'tgl_spdp' => $this->tgl_spdp,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
            'id_status' => $this->id_status,
            'is_internal' => $this->is_internal,
            'tgl_register_perkara' => $this->tgl_register_perkara,
            'tgl_selesai' => $this->tgl_selesai,
            'jenis_kasus' => $this->jenis_kasus,
        ]);

        $query->andFilterWhere(['like', 'id_pds_dik', $this->id_pds_dik])
            ->andFilterWhere(['like', 'id_satker', $this->id_satker])
            ->andFilterWhere(['like', 'penerima_spdp', $this->penerima_spdp])
            ->andFilterWhere(['like', 'asal_spdp', $this->asal_spdp])
            ->andFilterWhere(['like', 'perihal_spdp', $this->perihal_spdp])
            ->andFilterWhere(['like', 'no_spdp', $this->no_spdp])
            ->andFilterWhere(['like', 'isi_spdp', $this->isi_spdp])
            ->andFilterWhere(['like', 'uraian_spdp', $this->uraian_spdp])
            ->andFilterWhere(['like', 'atasan_penerima_spdp', $this->atasan_penerima_spdp])
            ->andFilterWhere(['like', 'create_by', $this->create_by])
            ->andFilterWhere(['like', 'update_by', $this->update_by])
            ->andFilterWhere(['like', 'id_satker_parent', $this->id_satker_parent])
            ->andFilterWhere(['like', 'no_berkas_perkara', $this->no_berkas_perkara])
            ->andFilterWhere(['like', 'kasus_posisi', $this->kasus_posisi])
            ->andFilterWhere(['like', 'create_ip', $this->create_ip])
            ->andFilterWhere(['like', 'update_ip', $this->update_ip])
            ->andFilterWhere(['like', 'id_pds_lid_parent', $this->id_pds_lid_parent]);

        return $dataProvider;
    }
}
