<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmBa10;

/**
 * PdmBa10Search represents the model behind the search form about `app\modules\pidum\models\PdmBa10`.
 */
class PdmBa10Search extends PdmBa10
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_t8', 'tgl_ba10', 'id_tersangka', 'no_reg_perkara', 'no_reg_tahanan', 'tgl_penahanan', 'no_sp', 'tgl_sp', 'tindakan', 'tgl_mulai', 'kepala_rutan', 'id_kejati', 'id_kejari', 'id_cabjari', 'created_ip', 'created_time', 'updated_ip', 'updated_time', 'nip_jaksa', 'nama'], 'safe'],
            [['id_ms_loktahanan', 'created_by', 'updated_by'], 'integer'],
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
        $query = PdmBa10::find();

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
            'tgl_ba10' => $this->tgl_ba10,
            'tgl_penahanan' => $this->tgl_penahanan,
            'tgl_sp' => $this->tgl_sp,
            'id_ms_loktahanan' => $this->id_ms_loktahanan,
            'tgl_mulai' => $this->tgl_mulai,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'no_surat_t8', $this->no_surat_t8])
            ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'no_reg_perkara', $this->no_reg_perkara])
            ->andFilterWhere(['like', 'no_reg_tahanan', $this->no_reg_tahanan])
            ->andFilterWhere(['like', 'no_sp', $this->no_sp])
            ->andFilterWhere(['like', 'tindakan', $this->tindakan])
            ->andFilterWhere(['like', 'kepala_rutan', $this->kepala_rutan])
            ->andFilterWhere(['like', 'id_kejati', $this->id_kejati])
            ->andFilterWhere(['like', 'id_kejari', $this->id_kejari])
            ->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip])
            ->andFilterWhere(['like', 'nip_jaksa', $this->nip_jaksa])
            ->andFilterWhere(['like', 'nama', $this->nama]);

        return $dataProvider;
    }
}
