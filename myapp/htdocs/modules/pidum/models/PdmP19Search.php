<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmP19;

/**
 * PdmP19Search represents the model behind the search form about `app\modules\pidum\models\PdmP19`.
 */
class PdmP19Search extends PdmP19
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p19', 'id_p24', 'no_surat', 'sifat', 'lampiran', 'tgl_dikeluarkan', 'dikeluarkan', 'kepada', 'di_kepada', 'petunjuk', 'id_penandatangan'], 'safe'],
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
        $query = PdmP19::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tgl_dikeluarkan' => $this->tgl_dikeluarkan,
			'id_perkara' => $this->id_perkara,
        ]);

        $query->andFilterWhere(['like', 'id_p19', $this->id_p19])
            ->andFilterWhere(['like', 'id_p24', $this->id_p24])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'sifat', $this->sifat])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'di_kepada', $this->di_kepada])
            ->andFilterWhere(['like', 'petunjuk', $this->petunjuk])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])	
						->andFilterWhere(['!=', 'flag',3])
			->andFilterWhere(['=', 'id_perkara', $id_perkara]);
        return $dataProvider;
    }
}
