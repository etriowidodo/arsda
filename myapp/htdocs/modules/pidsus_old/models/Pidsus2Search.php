<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidsus\models\PdsLid;

/**
 * PdsLidSearch represents the model behind the search form about `app\models\PdsLid`.
 */
class Pidsus2Search extends PdsLid
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_lid', 'id_satker', 'no_lap', 'tgl_diterima', 'penerima_lap', 'lokasi_lap', 'pelapor', 'perihal_lap', 'asal_surat_lap', 'no_surat_lap', 'tgl_lap', 'isi_surat_lap', 'uraian_surat_lap', 'penandatangan_lap', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
            [['id_status'], 'integer'],
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
        $query = PdsLid::find()->where("id_status=2")->orderBy('id_pds_lid');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tgl_diterima' => $this->tgl_diterima,
            'tgl_lap' => $this->tgl_lap,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
            'id_status' => $this->id_status,
        ]);

        $query->andFilterWhere(['like', 'id_pds_lid', $this->id_pds_lid])
            ->andFilterWhere(['like', 'id_satker', $this->id_satker])
            ->andFilterWhere(['like', 'no_lap', $this->no_lap])
            ->andFilterWhere(['like', 'penerima_lap', $this->penerima_lap])
            ->andFilterWhere(['like', 'lokasi_lap', $this->lokasi_lap])
            ->andFilterWhere(['like', 'pelapor', $this->pelapor])
            ->andFilterWhere(['like', 'perihal_lap', $this->perihal_lap])
            ->andFilterWhere(['like', 'asal_surat_lap', $this->asal_surat_lap])
            ->andFilterWhere(['like', 'no_surat_lap', $this->no_surat_lap])
            ->andFilterWhere(['like', 'isi_surat_lap', $this->isi_surat_lap])
            ->andFilterWhere(['like', 'uraian_surat_lap', $this->uraian_surat_lap])
            ->andFilterWhere(['like', 'penandatangan_lap', $this->penandatangan_lap])
            ->andFilterWhere(['like', 'create_by', $this->create_by])
            ->andFilterWhere(['like', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
