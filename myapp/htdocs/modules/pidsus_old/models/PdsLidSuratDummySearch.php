<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidsus\models\PdsLidSuratDummy;

/**
 * PdsLidSuratDummySearch represents the model behind the search form about `app\models\PdsLidSuratDummy`.
 */
class PdsLidSuratDummySearch extends PdsLidSuratDummy
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_lid_surat', 'type_surat', 'kejaksaan', 'nomor', 'sifat', 'perihal', 'tempat_surat', 'kepada', 'tempat_tujuan', 'tanggal_surat', 'nomor_pengaduan', 'tanggal_pengaduan', 'nama_penandatangan', 'pangkatnip'], 'safe'],
            [['jabatan_penandatangan'], 'integer'],
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
        $query = PdsLidSuratDummy::find();

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
            'tanggal_surat' => $this->tanggal_surat,
            'tanggal_pengaduan' => $this->tanggal_pengaduan,
            'jabatan_penandatangan' => $this->jabatan_penandatangan,
        ]);

        $query->andFilterWhere(['like', 'id_lid_surat', $this->id_lid_surat])
            ->andFilterWhere(['like', 'type_surat', $this->type_surat])
            ->andFilterWhere(['like', 'kejaksaan', $this->kejaksaan])
            ->andFilterWhere(['like', 'nomor', $this->nomor])
            ->andFilterWhere(['like', 'sifat', $this->sifat])
            ->andFilterWhere(['like', 'perihal', $this->perihal])
            ->andFilterWhere(['like', 'tempat_surat', $this->tempat_surat])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'tempat_tujuan', $this->tempat_tujuan])
            ->andFilterWhere(['like', 'nomor_pengaduan', $this->nomor_pengaduan])
            ->andFilterWhere(['like', 'nama_penandatangan', $this->nama_penandatangan])
            ->andFilterWhere(['like', 'pangkatnip', $this->pangkatnip]);

        return $dataProvider;
    }
}
