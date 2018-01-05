<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmBa3;

/**
 * PdmBA3Search represents the model behind the search form about `app\modules\pidum\models\PdmBA3`.
 */
class PdmBA3Search extends PdmBa3
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba3', 'id_perkara', 'tgl_pembuatan', 'jam', 'id_ms_saksi_ahli'], 'safe'],
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
    public function search($id_perkara, $params)
    {
		
		$query = PdmBA3::find();
        $query->where = "pdm_ba3.flag != '3'";
        $query->where = "pdm_ba3.id_perkara = '$id_perkara'";

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
            'tgl_pembuatan' => $this->tgl_pembuatan,
            'jam' => $this->jam,
			'id_perkara' => $id,
        ]);

        $query->andFilterWhere(['like', 'id_ba3', $this->id_ba3])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'id_ms_saksi_ahli', $this->id_ms_saksi_ahli]);

        return $dataProvider;
    }
}
