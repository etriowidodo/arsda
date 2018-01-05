<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\MsInstPelakPenyidikan;

/**
 * MsInstPelakPenyidikanSearch represents the model behind the search form about `app\modules\pidum\models\MsInstPelakPenyidikan`.
 */
class MsInstPelakPenyidikanSearch extends MsInstPelakPenyidikan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_ip', 'kode_ipp', 'nama', 'akronim'], 'safe'],
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
        $query = MsInstPelakPenyidikan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'upper(kode_ip)', strtoupper($this->kode_ip)])
            ->andFilterWhere(['like', 'upper(kode_ipp)', strtoupper($this->kode_ipp)])
            ->andFilterWhere(['like', 'upper(nama)', strtoupper($this->nama)])
            ->andFilterWhere(['like', 'upper(akronim)', strtoupper($this->akronim)]);

        return $dataProvider;
    }
}
