<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidsus\models\P16;

/**
 * P16Search represents the model behind the search form about `app\models\P16`.
 */
class P16Search extends P16
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_p16', 'dasar', 'dasar1', 'untuk', 'dikeluarkan', 'tgl_keluar', 'nip_ka_jaksa', 'pertimbangan', 'tembusan', 'no_spdp', 'tgl_spdp', 'penyidik', 'tgl_terima', 'jenis_perkara', 'waktu_terjadi', 'tempat_terjadi', 'created_time', 'created_by', 'updated_by', 'updated_time', 'kasus_posisi', 'inst_satkerkd'], 'safe'],
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
        $query = P16::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tgl_keluar' => $this->tgl_keluar,
            'tgl_spdp' => $this->tgl_spdp,
            'tgl_terima' => $this->tgl_terima,
            'waktu_terjadi' => $this->waktu_terjadi,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
            'status_sinkron' => $this->status_sinkron,
        ]);

        $query->andFilterWhere(['like', 'no_p16', $this->no_p16])
            ->andFilterWhere(['like', 'dasar', $this->dasar])
            ->andFilterWhere(['like', 'dasar1', $this->dasar1])
            ->andFilterWhere(['like', 'untuk', $this->untuk])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'nip_ka_jaksa', $this->nip_ka_jaksa])
            ->andFilterWhere(['like', 'pertimbangan', $this->pertimbangan])
            ->andFilterWhere(['like', 'tembusan', $this->tembusan])
            ->andFilterWhere(['like', 'no_spdp', $this->no_spdp])
            ->andFilterWhere(['like', 'penyidik', $this->penyidik])
            ->andFilterWhere(['like', 'jenis_perkara', $this->jenis_perkara])
            ->andFilterWhere(['like', 'tempat_terjadi', $this->tempat_terjadi])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by])
            ->andFilterWhere(['like', 'kasus_posisi', $this->kasus_posisi])
            ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd]);

        return $dataProvider;
    }
}