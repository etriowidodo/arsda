<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\VLaporanP6;

/**
 * VLaporanP6Search represents the model behind the search form about `app\modules\pidum\models\VLaporanP6`.
 */
class VLaporanP6Search extends VLaporanP6
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tgl_terima', 'wilayah_kerja', 'nama_lengkap', 'kasus_posisi', 'asal_perkara', 'tgl_dihentikan', 'tgl_dikesampingkan', 'tgl_dikirim_ke', 'no_denda_ganti', 'tgl_denda_ganti', 'tgl_dilimpahkan', 'keterangan'], 'safe'],
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
        $query = VLaporanP6::find();

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
            'tgl_terima' => $this->tgl_terima,
        ]);

        $query->andFilterWhere(['like', 'wilayah_kerja', $this->wilayah_kerja])
            ->andFilterWhere(['like', 'nama_lengkap', $this->nama_lengkap])
            ->andFilterWhere(['like', 'kasus_posisi', $this->kasus_posisi])
            ->andFilterWhere(['like', 'asal_perkara', $this->asal_perkara])
            ->andFilterWhere(['like', 'tgl_dihentikan', $this->tgl_dihentikan])
            ->andFilterWhere(['like', 'tgl_dikesampingkan', $this->tgl_dikesampingkan])
            ->andFilterWhere(['like', 'tgl_dikirim_ke', $this->tgl_dikirim_ke])
            ->andFilterWhere(['like', 'no_denda_ganti', $this->no_denda_ganti])
            ->andFilterWhere(['like', 'tgl_denda_ganti', $this->tgl_denda_ganti])
            ->andFilterWhere(['like', 'tgl_dilimpahkan', $this->tgl_dilimpahkan])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
