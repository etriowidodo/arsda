<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmP18;

/**
 * PdmP18Search represents the model behind the search form about `app\modules\pidum\models\PdmP18`.
 */
class PdmP18Search extends PdmP18
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p18', 'id_p24', 'no_surat', 'sifat', 'lampiran', 'tgl_dikeluarkan', 'dikeluarkan', 'kepada', 'di_kepada','id_perkara', 'id_penandatangan','id_berkas'], 'safe'],
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
        $query = PdmP18::find();

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
        ]);

        $query->andFilterWhere(['like', 'id_p18', $this->id_p18])
            ->andFilterWhere(['like', 'id_p24', $this->id_p24])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'sifat', $this->sifat])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'di_kepada', $this->di_kepada])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
			     ->andFilterWhere(['!=', 'flag', 3])
			->andFilterWhere(['=', 'id_perkara', $id_perkara]);

        return $dataProvider;
    }
}
