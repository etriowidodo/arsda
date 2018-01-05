<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmT13;

/**
 * PdmT13Search represents the model behind the search form about `app\modules\pidum\models\PdmT13`.
 */
class PdmT13Search extends PdmT13
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_t13', 'id_t8', 'no_surat', 'tgl_surat', 'dikeluarkan', 'kepada', 'sp_penahanan', 'penetapan', 'no_penahanan', 'tgl_penahanan', 'keperluan', 'menghadap', 'tempat', 'tgl_penetapan', 'jam', 'id_penandatangan'], 'safe'],
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
        $query = PdmT13::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->andWhere(['<>', 'flag', '3']);
        $query->andWhere(['=', 'id_perkara', $id_perkara]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tgl_surat' => $this->tgl_surat,
            'tgl_penahanan' => $this->tgl_penahanan,
            'tgl_penetapan' => $this->tgl_penetapan,
            'jam' => $this->jam,
        ]);

        $query->andFilterWhere(['like', 'id_t13', $this->id_t13])
            ->andFilterWhere(['like', 'id_t8', $this->id_t8])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'sp_penahanan', $this->sp_penahanan])
            ->andFilterWhere(['like', 'penetapan', $this->penetapan])
            ->andFilterWhere(['like', 'no_penahanan', $this->no_penahanan])
            ->andFilterWhere(['like', 'keperluan', $this->keperluan])
            ->andFilterWhere(['like', 'menghadap', $this->menghadap])
            ->andFilterWhere(['like', 'tempat', $this->tempat])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan]);

        return $dataProvider;
    }
}
