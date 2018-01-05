<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidsus\models\PdsLidRenlid;

/**
 * PdsLidRenlidSearch represents the model behind the search form about `app\models\PdsLidRenlid`.
 */
class PdsLidRenlidSearch extends PdsLidRenlid
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_lid_renlid', 'id_pds_lid_surat', 'laporan', 'kasus_posisi', 'dugaan_pasal', 'alat_bukti', 'sumber', 'pelaksana', 'tindakan_hukum', 'koor_dan_dal', 'keterangan', 'create_by', 'create_date', 'update_by', 'update_date', 'waktu_tempat'], 'safe'],
            [['no_urut'], 'integer'],
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
    public function search($id,$params)
    {
        $query = PdsLidRenlid::find()->where(['id_pds_lid_surat'=>$id,'flag'=>1]);

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
            'no_urut' => $this->no_urut,
            'create_date' => $this->create_date,
            'update_date' => $this->update_date,
        ]);

        $query->andFilterWhere(['like', 'id_pds_lid_renlid', $this->id_pds_lid_renlid])
            ->andFilterWhere(['like', 'id_pds_lid_surat', $this->id_pds_lid_surat])
            ->andFilterWhere(['like', 'laporan', $this->laporan])
            ->andFilterWhere(['like', 'kasus_posisi', $this->kasus_posisi])
            ->andFilterWhere(['like', 'dugaan_pasal', $this->dugaan_pasal])
            ->andFilterWhere(['like', 'alat_bukti', $this->alat_bukti])
            ->andFilterWhere(['like', 'sumber', $this->sumber])
            ->andFilterWhere(['like', 'pelaksana', $this->pelaksana])
            ->andFilterWhere(['like', 'tindakan_hukum', $this->tindakan_hukum])
            ->andFilterWhere(['like', 'waktu_tempat', $this->waktu_tempat])
            ->andFilterWhere(['like', 'koor_dan_dal', $this->koor_dan_dal])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'create_by', $this->create_by])
            ->andFilterWhere(['like', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
