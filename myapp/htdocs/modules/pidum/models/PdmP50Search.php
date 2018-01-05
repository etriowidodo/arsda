<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmP50;

/**
 * PdmP50Search represents the model behind the search form about `app\modules\pidum\models\PdmP50`.
 */
class PdmP50Search extends PdmP50
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_surat_p50', 'no_register_perkara', 'no_surat', 'sifat', 'lampiran', 'kepada', 'di_kepada', 'dikeluarkan', 'tgl_dikeluarkan', 'id_tersangka', 'put_pengadilan', 'no_put_pengadilan', 'tgl_put_pengadilan', 'tgl_pelaksanaan', 'uraian', 'id_penandatangan', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time', 'no_akta', 'no_reg_tahanan'], 'safe'],
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
        $query = PdmP50::find();

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
            'tgl_pelaksanaan' => $this->tgl_pelaksanaan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'no_surat_p50', $this->no_surat_p50])
            ->andFilterWhere(['like', 'no_register_perkara', $this->no_register_perkara])
            ->andFilterWhere(['like', 'no_surat', $this->no_surat])
            ->andFilterWhere(['like', 'sifat', $this->sifat])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran])
            ->andFilterWhere(['like', 'kepada', $this->kepada])
            ->andFilterWhere(['like', 'di_kepada', $this->di_kepada])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'put_pengadilan', $this->put_pengadilan])
            ->andFilterWhere(['like', 'no_put_pengadilan', $this->no_put_pengadilan])
            ->andFilterWhere(['like', 'uraian', $this->uraian])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip])
            ->andFilterWhere(['like', 'no_akta', $this->no_akta])
            ->andFilterWhere(['like', 'no_reg_tahanan', $this->no_reg_tahanan]);

        return $dataProvider;
    }
}
