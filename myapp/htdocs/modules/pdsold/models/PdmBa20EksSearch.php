<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmBa20Eks;

/**
 * PdmBa20EksSearch represents the model behind the search form about `app\modules\pidum\models\PdmBa20Eks`.
 */
class PdmBa20EksSearch extends PdmBa20Eks
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_akta', 'no_reg_tahanan', 'no_eksekusi', 'tgl_ba20', 'lokasi', 'id_tersangka', 'bar_buk', 'nama', 'pekerjaan', 'alamat', 'id_kejati', 'id_kejari', 'id_cabjari', 'created_ip', 'created_time', 'updated_ip', 'updated_time', 'surat_perintah', 'no_surat_perintah', 'tgl_surat_perintah', 'no_putusan', 'tgl_putusan', 'no_surat_p16a', 'saksi'], 'safe'],
            [['created_by', 'updated_by', 'no_urut_jaksa_p16a'], 'integer'],
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
        $query = PdmBa20Eks::find();

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
            'tgl_ba20' => $this->tgl_ba20,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
            'tgl_surat_perintah' => $this->tgl_surat_perintah,
            'tgl_putusan' => $this->tgl_putusan,
            'no_urut_jaksa_p16a' => $this->no_urut_jaksa_p16a,
        ]);

        $query->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'no_akta', $this->no_akta])
            ->andFilterWhere(['like', 'no_reg_tahanan', $this->no_reg_tahanan])
            ->andFilterWhere(['like', 'no_eksekusi', $this->no_eksekusi])
            ->andFilterWhere(['like', 'lokasi', $this->lokasi])
            ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'bar_buk', $this->bar_buk])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'pekerjaan', $this->pekerjaan])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'id_kejati', $this->id_kejati])
            ->andFilterWhere(['like', 'id_kejari', $this->id_kejari])
            ->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip])
            ->andFilterWhere(['like', 'surat_perintah', $this->surat_perintah])
            ->andFilterWhere(['like', 'no_surat_perintah', $this->no_surat_perintah])
            ->andFilterWhere(['like', 'no_putusan', $this->no_putusan])
            ->andFilterWhere(['like', 'no_surat_p16a', $this->no_surat_p16a])
            ->andFilterWhere(['like', 'saksi', $this->saksi]);

        return $dataProvider;
    }
}
