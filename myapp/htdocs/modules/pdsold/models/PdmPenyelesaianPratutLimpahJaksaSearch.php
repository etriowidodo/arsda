<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmPenyelesaianPratutLimpahJaksa;

/**
 * PdmPenyelesaianPratutLimpahJaksaSearch represents the model behind the search form about `app\modules\pidum\models\PdmPenyelesaianPratutLimpahJaksa`.
 */
class PdmPenyelesaianPratutLimpahJaksaSearch extends PdmPenyelesaianPratutLimpahJaksa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pratut_limpah_jaksa', 'peg_nip', 'nama', 'pangkat', 'jabatan'], 'safe'],
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
        $query = PdmPenyelesaianPratutLimpahJaksa::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id_pratut_limpah_jaksa', $this->id_pratut_limpah_jaksa])
            ->andFilterWhere(['like', 'peg_nip', $this->peg_nip])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'pangkat', $this->pangkat])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan]);

        return $dataProvider;
    }
}
