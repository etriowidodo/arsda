<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmBa16;

/**
 * PdmBa16Search represents the model behind the search form about `app\modules\pidum\models\PdmBa16`.
 */
class PdmBa16Search extends PdmBa16
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba16', 'id_perkara', 'tgl_surat', 'id_tersangka', 'nama1', 'pekerjaan1', 'nama2', 'pekerjaan2', 'penggeledahan', 'nama_geledah', 'alamat_geledah', 'pekerjaan_geledah', 'penyitaan', 'nama_sita', 'alamat_sita', 'pekerjaan_sita', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['umur1', 'umur2', 'created_by', 'updated_by'], 'integer'],
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
        $query = PdmBa16::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

       // $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tgl_surat' => $this->tgl_surat,
            'umur1' => $this->umur1,
            'umur2' => $this->umur2,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_ba16', $this->id_ba16])
            ->andFilterWhere(['like', 'id_perkara', $params])
            ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'nama1', $this->nama1])
            ->andFilterWhere(['like', 'pekerjaan1', $this->pekerjaan1])
            ->andFilterWhere(['like', 'nama2', $this->nama2])
            ->andFilterWhere(['like', 'pekerjaan2', $this->pekerjaan2])
            ->andFilterWhere(['like', 'penggeledahan', $this->penggeledahan])
            ->andFilterWhere(['like', 'nama_geledah', $this->nama_geledah])
            ->andFilterWhere(['like', 'alamat_geledah', $this->alamat_geledah])
            ->andFilterWhere(['like', 'pekerjaan_geledah', $this->pekerjaan_geledah])
            ->andFilterWhere(['like', 'penyitaan', $this->penyitaan])
            ->andFilterWhere(['like', 'nama_sita', $this->nama_sita])
            ->andFilterWhere(['like', 'alamat_sita', $this->alamat_sita])
            ->andFilterWhere(['like', 'pekerjaan_sita', $this->pekerjaan_sita])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
