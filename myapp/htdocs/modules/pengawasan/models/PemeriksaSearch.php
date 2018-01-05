<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Pemeriksa;

/**
 * PemeriksaSearch represents the model behind the search form about `app\modules\pengawasan\models\Pemeriksa`.
 */
class PemeriksaSearch extends Pemeriksa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pemeriksa', 'id_register', 'peg_nik', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['id_h_jabatan', 'dugaan_pelaporan', 'sp_was_1', 'was_9', 'was_13', 'l_was_1', 'ba_was_2', 'was_27_kla', 'sp_was_2', 'was_10', 'was_12', 'ba_was_3', 'l_was_2', 'was_15', 'was_27_inspek', 'was_18', 'ba_was_5', 'ba_was_7', 'sk_was_2a', 'sk_was_2b', 'sk_was_2c', 'sk_was_3a', 'sk_was_3b', 'sk_was_3c', 'sk_was_4a', 'sk_was_4b', 'sk_was_4c', 'sk_was_4d', 'sk_was_4e', 'flag', 'created_by', 'updated_by'], 'integer'],
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
        $query = Pemeriksa::find();

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
            'id_h_jabatan' => $this->id_h_jabatan,
            'dugaan_pelaporan' => $this->dugaan_pelaporan,
            'sp_was_1' => $this->sp_was_1,
            'was_9' => $this->was_9,
            'was_13' => $this->was_13,
            'l_was_1' => $this->l_was_1,
            'ba_was_2' => $this->ba_was_2,
            'was_27_kla' => $this->was_27_kla,
            'sp_was_2' => $this->sp_was_2,
            'was_10' => $this->was_10,
            'was_12' => $this->was_12,
            'ba_was_3' => $this->ba_was_3,
            'l_was_2' => $this->l_was_2,
            'was_15' => $this->was_15,
            'was_27_inspek' => $this->was_27_inspek,
            'was_18' => $this->was_18,
            'ba_was_5' => $this->ba_was_5,
            'ba_was_7' => $this->ba_was_7,
            'sk_was_2a' => $this->sk_was_2a,
            'sk_was_2b' => $this->sk_was_2b,
            'sk_was_2c' => $this->sk_was_2c,
            'sk_was_3a' => $this->sk_was_3a,
            'sk_was_3b' => $this->sk_was_3b,
            'sk_was_3c' => $this->sk_was_3c,
            'sk_was_4a' => $this->sk_was_4a,
            'sk_was_4b' => $this->sk_was_4b,
            'sk_was_4c' => $this->sk_was_4c,
            'sk_was_4d' => $this->sk_was_4d,
            'sk_was_4e' => $this->sk_was_4e,
            'flag' => $this->flag,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_pemeriksa', $this->id_pemeriksa])
            ->andFilterWhere(['like', 'id_register', $this->id_register])
            ->andFilterWhere(['like', 'peg_nik', $this->peg_nik])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
