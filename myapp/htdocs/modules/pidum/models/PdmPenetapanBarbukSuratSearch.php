<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmPenetapanBarbukSurat;

/**
 * PdmPenetapanBarbukSuratSearch represents the model behind the search form about `app\modules\pidum\models\PdmPenetapanBarbukSurat`.
 */
class PdmPenetapanBarbukSuratSearch extends PdmPenetapanBarbukSurat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_penetapan_barbuk_surat', 'id_sita', 'nama_surat', 'no_surat', 'tgl_surat', 'tgl_diterima'], 'safe'],
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
        $query = PdmPenetapanBarbukSurat::find();

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
            'tgl_surat' => $this->tgl_surat,
            'tgl_diterima' => $this->tgl_diterima,
        ]);

        $query->andFilterWhere(['like', 'id_penetapan_barbuk_surat', $this->id_penetapan_barbuk_surat])
            ->andFilterWhere(['like', 'id_sita', $this->id_sita])
            ->andFilterWhere(['like', 'nama_surat', $this->nama_surat])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat]);

        return $dataProvider;
    }
}
