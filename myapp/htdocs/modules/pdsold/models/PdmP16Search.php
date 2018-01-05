<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmP16;

/**
 * PdmP16Search represents the model behind the search form about `app\modules\pidum\models\PdmP16`.
 */
class PdmP16Search extends PdmP16
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p16', 'id_perkara', 'no_surat', 'dikeluarkan', 'tgl_dikeluarkan', 'id_penandatangan'], 'safe'],
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
        $query = PdmP16::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
	//$query->andFilterWhere(['=', 'id_perkara', $id_perkara]);
        $query->andFilterWhere(['tgl_dikeluarkan' => $this->tgl_dikeluarkan, ]);
	

        $query->andFilterWhere(['like', 'id_p16', $this->id_p16])
           ->andFilterWhere(['=', 'id_perkara', $id_perkara])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan]);

        return $dataProvider;
    }
}
