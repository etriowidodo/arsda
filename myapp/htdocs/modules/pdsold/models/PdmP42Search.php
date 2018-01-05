<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmP42;

/**
 * PdmP42Search represents the model behind the search form about `app\modules\pidum\models\PdmP42`.
 */
class PdmP42Search extends PdmP42
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p42', 'no_perkara', 'ket_saksi', 'ket_ahli', 'ket_surat', 'petunjuk', 'ket_tersangka', 'barbuk', 'unsur_dakwaan', 'memberatkan', 'meringankan', 'tgl_dikeluarkan', 'id_penandatangan', 'uraian', 'id_kejati', 'id_kejari', 'id_cabjari', 'created_ip', 'created_time', 'updated_ip', 'updated_time', 'no_penetapan_hakim', 'unsur_pasal'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
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
    public function search($no_register, $params)
    {
        $query = PdmP42::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->andWhere(['=', 'no_register_perkara', $no_register]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tgl_dikeluarkan' => $this->tgl_dikeluarkan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'no_surat_p42', $this->no_surat_p42])
            ->andFilterWhere(['like', 'no_perkara', $this->no_perkara])
            ->andFilterWhere(['like', 'ket_saksi', $this->ket_saksi])
            ->andFilterWhere(['like', 'ket_ahli', $this->ket_ahli])
            ->andFilterWhere(['like', 'ket_surat', $this->ket_surat])
            ->andFilterWhere(['like', 'petunjuk', $this->petunjuk])
            ->andFilterWhere(['like', 'ket_tersangka', $this->ket_tersangka])
            ->andFilterWhere(['like', 'barbuk', $this->barbuk])
            ->andFilterWhere(['like', 'unsur_dakwaan', $this->unsur_dakwaan])
            ->andFilterWhere(['like', 'memberatkan', $this->memberatkan])
            ->andFilterWhere(['like', 'meringankan', $this->meringankan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'uraian', $this->uraian])
            ->andFilterWhere(['like', 'id_kejati', $this->id_kejati])
            ->andFilterWhere(['like', 'id_kejari', $this->id_kejari])
            ->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip])
            ->andFilterWhere(['like', 'no_penetapan_hakim', $this->no_penetapan_hakim])
            ->andFilterWhere(['like', 'unsur_pasal', $this->unsur_pasal]);

        return $dataProvider;
    }
}
