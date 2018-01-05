<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidsus\models\PdsPasal;

/**
 * PdsPasalSearch represents the model behind the search form about `app\models\PdsPasal`.
 */
class PdsPasalSearch extends PdsPasal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pds_pasal', 'id_pds_lid_surat', 'tipe_pasal', 'pasal', 'create_by', 'create_date', 'update_by', 'update_date', 'penghubung', 'id_pds_pasal_parent'], 'safe'],
            [['no_urut', 'sub_no_urut'], 'integer'],
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
        $query = PdsPasal::find();

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
            'sub_no_urut' => $this->sub_no_urut,
        ]);

        $query->andFilterWhere(['like', 'id_pds_pasal', $this->id_pds_pasal])
            ->andFilterWhere(['like', 'id_pds_lid_surat', $this->id_pds_lid_surat])
            ->andFilterWhere(['like', 'tipe_pasal', $this->tipe_pasal])
            ->andFilterWhere(['like', 'pasal', $this->pasal])
            ->andFilterWhere(['like', 'create_by', $this->create_by])
            ->andFilterWhere(['like', 'update_by', $this->update_by])
            ->andFilterWhere(['like', 'penghubung', $this->penghubung])
            ->andFilterWhere(['like', 'id_pds_pasal_parent', $this->id_pds_pasal_parent]);

        return $dataProvider;
    }
}
