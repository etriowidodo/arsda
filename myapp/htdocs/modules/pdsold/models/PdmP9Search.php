<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmP9;

/**
 * PdmP9Search represents the model behind the search form about `app\modules\pidum\models\PdmP9`.
 */
class PdmP9Search extends PdmP9
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p9', 'id_perkara', 'no_surat', 'kepada', 'di_kepada', 'tgl_panggilan', 'jam', 'tempat', 'menghadap', 'sebagai', 'id_panggilan_saksi', 'dikeluarkan', 'tgl_dikeluarkan', 'id_penandatangan', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['id_msstatusdata', 'created_by', 'updated_by'], 'integer'],
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
    public function search($id_perkara,$params)
    {
        $query = PdmP9::find();
        $query->where = "pdm_p9.flag != '3'";
        $query->where = "pdm_p9.id_perkara = '".$id_perkara."'";

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		 $query->andWhere(['!=', 'flag', '3']);

        $query->andFilterWhere([
            'tgl_panggilan' => $this->tgl_panggilan,
            'jam' => $this->jam,
            'id_msstatusdata' => $this->id_msstatusdata,
            'tgl_dikeluarkan' => $this->tgl_dikeluarkan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
			'id_perkara' => $id,
        ]);

        $query->andFilterWhere(['like', 'id_p9', $this->id_p9])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'di_kepada', $this->di_kepada])
            ->andFilterWhere(['like', 'tempat', $this->tempat])
            ->andFilterWhere(['like', 'menghadap', $this->menghadap])
            ->andFilterWhere(['like', 'sebagai', $this->sebagai])
            ->andFilterWhere(['like', 'id_panggilan_saksi', $this->id_panggilan_saksi])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);
           
        return $dataProvider;
    }
}
