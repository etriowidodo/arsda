<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidsus\models\PdsDikRendik;

/**
 * PdsDikRendikSearch represents the model behind the search form about `app\models\PdsDikRendik`.
 */
class PdsDikRendikSearch extends PdsDikRendik
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_dik_rendik', 'id_pds_dik_surat', 'kasus_posisi', 'pasal_disangkakan', 'alat_bukti', 'tindakan_hukum', 'waktu_tempat', 'koor_dan_dal', 'keterangan', 'create_by', 'create_date', 'update_by', 'update_date'], 'safe'],
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
    public function search($params,$idDikSurat)
    {
        $query = PdsDikRendik::find()->where(['id_pds_dik_surat'=>$idDikSurat, 'flag'=>'1'])->orderby('no_urut');

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

        $query->andFilterWhere(['like', 'id_pds_dik_rendik', $this->id_pds_dik_rendik])
            ->andFilterWhere(['like', 'id_pds_dik_surat', $this->id_pds_dik_surat])
            ->andFilterWhere(['like', 'kasus_posisi', $this->kasus_posisi])
            ->andFilterWhere(['like', 'pasal_disangkakan', $this->pasal_disangkakan])
            ->andFilterWhere(['like', 'alat_bukti', $this->alat_bukti])
            ->andFilterWhere(['like', 'tindakan_hukum', $this->tindakan_hukum])
            ->andFilterWhere(['like', 'waktu_tempat', $this->waktu_tempat])
            ->andFilterWhere(['like', 'koor_dan_dal', $this->koor_dan_dal])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'create_by', $this->create_by])
            ->andFilterWhere(['like', 'update_by', $this->update_by]);

        return $dataProvider;
    }
}
