<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmPenyelesaianPratutLimpahTersangka;

/**
 * PdmPenyelesaianPratutLimpahTersangkaSearch represents the model behind the search form about `app\modules\pidum\models\PdmPenyelesaianPratutLimpahTersangka`.
 */
class PdmPenyelesaianPratutLimpahTersangkaSearch extends PdmPenyelesaianPratutLimpahTersangka
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pratut_limpah_tersangka', 'id_ms_tersangka_berkas', 'status_penahanan'], 'safe'],
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
        $query = PdmPenyelesaianPratutLimpahTersangka::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id_pratut_limpah_tersangka', $this->id_pratut_limpah_tersangka])
            ->andFilterWhere(['like', 'id_ms_tersangka_berkas', $this->id_ms_tersangka_berkas])
            ->andFilterWhere(['like', 'status_penahanan', $this->status_penahanan]);

        return $dataProvider;
    }
}
