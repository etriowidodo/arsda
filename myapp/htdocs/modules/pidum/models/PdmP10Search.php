<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmP10;

/**
 * PdmP10Search represents the model behind the search form about `app\modules\pidum\models\PdmP10`.
 */
class PdmP10Search extends PdmP10
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p10', 'no_surat', 'sifat', 'lampiran', 'dikeluarkan', 'tgl_dikeluarkan', 'ket_ahli', 'id_penandatangan'], 'safe'],
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
        $query = PdmP10::find();
        $query->where = "pdm_p10.flag != '3'";
        $query->where = "pdm_p10.id_perkara = '$id_perkara'";

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
			'no_surat' => $this->no_surat,
			'id_perkara' => $id,
        ]);

        $query->andFilterWhere(['like', 'id_p10', $this->id_p10])
             ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'sifat', $this->sifat])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])            
            ->andFilterWhere(['like', 'ket_ahli', $this->ket_ahli])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
			->andFilterWhere(['like', 'flag', $this->flag])
			->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
