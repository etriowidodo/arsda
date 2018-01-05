<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmP45Upayahukum;

/**
 * PdmP45UpayahukumSearch represents the model behind the search form about `app\modules\pidum\models\PdmP45Upayahukum`.
 */
class PdmP45UpayahukumSearch extends PdmP45Upayahukum
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_register_perkara', 'no_surat_p45', 'sifat', 'no_akta', 'lampiran', 'kepada', 'di_kepada', 'dikeluarkan', 'tgl_dikeluarkan', 'id_tersangka', 'put_pengadilan', 'no_put_pengadilan', 'tgl_put_pengadilan', 'menyatakan', 'tgl_tuntutan', 'menuntut', 'pernyataan_terdakwa', 'pernyataan_jaksa', 'pertimbangan', 'id_penandatangan', 'id_kejati', 'id_kejari', 'id_cabjari', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
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
    public function search($no_register,$no_akta,$params)
    {
        $query = PdmP45Upayahukum::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->andWhere(['=', 'no_register_perkara', $no_register]);
        $query->andWhere(['=', 'no_akta', $no_akta]);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tgl_dikeluarkan' => $this->tgl_dikeluarkan,
            'tgl_put_pengadilan' => $this->tgl_put_pengadilan,
            'tgl_tuntutan' => $this->tgl_tuntutan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'no_surat_p45', $this->no_surat_p45])
            ->andFilterWhere(['like', 'sifat', $this->sifat])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'no_akta', $this->no_akta])
            ->andFilterWhere(['like', 'di_kepada', $this->di_kepada])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'put_pengadilan', $this->put_pengadilan])
            ->andFilterWhere(['like', 'no_put_pengadilan', $this->no_put_pengadilan])
            ->andFilterWhere(['like', 'menyatakan', $this->menyatakan])
            ->andFilterWhere(['like', 'menuntut', $this->menuntut])
            ->andFilterWhere(['like', 'pernyataan_terdakwa', $this->pernyataan_terdakwa])
            ->andFilterWhere(['like', 'pernyataan_jaksa', $this->pernyataan_jaksa])
            ->andFilterWhere(['like', 'pertimbangan', $this->pertimbangan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'id_kejati', $this->id_kejati])
            ->andFilterWhere(['like', 'id_kejari', $this->id_kejari])
            ->andFilterWhere(['like', 'id_cabjari', $this->id_cabjari])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
