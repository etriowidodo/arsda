<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidsus\models\PdsLidSurat;

/**
 * PdsLidSuratSearch represents the model behind the search form about `app\models\PdsLidSurat`.
 */
class PdsLidSuratSearch extends PdsLidSurat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_lid_surat', 'id_pds_lid', 'id_jenis_surat', 'no_surat', 'tgl_surat','jam_surat', 'lokasi_surat', 'sifat_surat', 'lampiran_surat', 'perihal_lap', 'kepada', 'kepada_lokasi', 'id_ttd', 'create_by', 'create_date', 'update_by', 'update_date', 'id_pds_lid_surat_parent'], 'safe'],
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
    public function search($params,$jenisSurat,$idPdsLid)
    {	
    	if ($jenisSurat=='all'){
    		$query = PdsLidSurat::find()->where("id_pds_lid='".$idPdsLid."' and (flag<>'3' OR flag is null) ")->orderBy('create_date');    		 
    	}
    	else {
        	$query = PdsLidSurat::find()->where("id_jenis_surat='".$jenisSurat."' and id_pds_lid='".$idPdsLid."' and flag<>'3'")->orderBy('create_date');
    	}
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
        	'jam_surat' => $this->jam_surat,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
            'id_status' => $this->id_status,
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
