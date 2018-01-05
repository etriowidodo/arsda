<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidsus\models\PdsLidSurat;

/**
 * Pidsus9Search represents the model behind the search form about `app\models\PdsLidSurat`.
 */
class Pidsus9Search extends PdsLidSurat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_lid_surat', 'id_pds_lid', 'id_jenis_surat', 'no_surat', 'tgl_surat', 'lokasi_surat', 'sifat_surat', 'lampiran_surat', 'perihal_lap', 'kepada', 'kepada_lokasi', 'id_ttd', 'create_by', 'create_date', 'update_by', 'update_date', 'id_pds_lid_surat_parent', 'jam_surat'], 'safe'],
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
        $query = PdsLidSurat::find();

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
            'tgl_surat' => $this->tgl_surat,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
            'id_status' => $this->id_status,
            'jam_surat' => $this->jam_surat,
        ]);

        $query->andFilterWhere(['like', 'id_pds_lid_surat', $this->id_pds_lid_surat])
            ->andFilterWhere(['like', 'id_pds_lid', $this->id_pds_lid])
            ->andFilterWhere(['like', 'id_jenis_surat', $this->id_jenis_surat])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'lokasi_surat', $this->lokasi_surat])
            ->andFilterWhere(['like', 'sifat_surat', $this->sifat_surat])
            ->andFilterWhere(['like', 'lampiran_surat', $this->lampiran_surat])
            ->andFilterWhere(['like', 'perihal_lap', $this->perihal_lap])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'kepada_lokasi', $this->kepada_lokasi])
            ->andFilterWhere(['like', 'id_ttd', $this->id_ttd])
            ->andFilterWhere(['like', 'create_by', $this->create_by])
            ->andFilterWhere(['like', 'update_by', $this->update_by])
            ->andFilterWhere(['like', 'id_pds_lid_surat_parent', $this->id_pds_lid_surat_parent]);

        return $dataProvider;
    }
}
