<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmP17;

/**
 * PdmP17Search represents the model behind the search form about `app\modules\pidum\models\PdmP17`.
 */
class PdmP17Search extends PdmP17
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p16', 'id_p17', 'no_surat', 'sifat', 'lampiran',  'tgl_dikeluarkan', 'dikeluarkan', 'kepada', 'di_kepada', 'id_penandatangan'], 'safe'],
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
        $query = PdmP17::find();

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

        $query->andFilterWhere(['like', 'id_p16', $this->id_p16])
            ->andFilterWhere(['like', 'id_p17', $this->id_p17])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'sifat', $this->sifat])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'di_kepada', $this->di_kepada])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan]);

        return $dataProvider;
    }
}
