<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was3;

/**
 * Was3Search represents the model behind the search form about `app\modules\pengawasan\models\Was3`.
 */
class Was3Search extends Was3
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_was_3', 'no_was_3', 'no_surat', 'inst_satkerkd', 'id_register', 'tgl_was_3', 'ttd_peg_nik', 'upload_file', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['kpd_was_3', 'ttd_was_3', 'id_terlapor', 'flag', 'created_by', 'updated_by', 'ttd_id_jabatan', 'jml_lampiran', 'satuan_lampiran'], 'integer'],
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
        $query = Was3::find();

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
            'tgl_was_3' => $this->tgl_was_3,
            'kpd_was_3' => $this->kpd_was_3,
            'ttd_was_3' => $this->ttd_was_3,
            'id_terlapor' => $this->id_terlapor,
            'flag' => $this->flag,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
            'ttd_id_jabatan' => $this->ttd_id_jabatan,
            'jml_lampiran' => $this->jml_lampiran,
            'satuan_lampiran' => $this->satuan_lampiran,
			'no_surat' => $this->no_surat,
        ]);

        $query->andFilterWhere(['like', 'id_was_3', $this->id_was_3])
            ->andFilterWhere(['like', 'no_was_3', $this->no_was_3])
			->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd])
            ->andFilterWhere(['like', 'id_register', $this->id_register])
            ->andFilterWhere(['like', 'ttd_peg_nik', $this->ttd_peg_nik])
            ->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
