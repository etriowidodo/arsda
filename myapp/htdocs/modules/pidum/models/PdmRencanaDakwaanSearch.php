<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\PdmRencanaDakwaan;

/**
 * pdmP29Search represents the model behind the search form about `app\modules\pidum\models\PdmRencanaDakwaanSearch`.
 */
class PdmRencanaDakwaanSearch extends PdmRencanaDakwaan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_rencana_dakwaan', 'no_perkara', 'tgl_awal_rutan', 'tgl_akhir_rutan', 'tgl_awal_rumah', 'tgl_akhir_rumah', 'tgl_awal_kota', 'tgl_akhir_kota', 'perpanjangan', 'tgl_perpanjangan', 'pengalihan', 'tgl_pengalihan', 'tgl_penangguhan', 'pencabutan', 'tgl_pencabutan', 'dikeluarkan', 'tgl_dikeluarkan', 'dakwaan', 'id_penandatangan', 'id_perkara', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
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
    public function search($id_perkara, $params)
    {
        $query = PdmRencanaDakwaanSearch::find();

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
            'tgl_awal_rutan' => $this->tgl_awal_rutan,
            'tgl_akhir_rutan' => $this->tgl_akhir_rutan,
            'tgl_awal_rumah' => $this->tgl_awal_rumah,
            'tgl_akhir_rumah' => $this->tgl_akhir_rumah,
            'tgl_awal_kota' => $this->tgl_awal_kota,
            'tgl_akhir_kota' => $this->tgl_akhir_kota,
            'tgl_perpanjangan' => $this->tgl_perpanjangan,
            'tgl_pengalihan' => $this->tgl_pengalihan,
            'tgl_penangguhan' => $this->tgl_penangguhan,
            'tgl_pencabutan' => $this->tgl_pencabutan,
            'tgl_dikeluarkan' => $this->tgl_dikeluarkan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andWhere(['<>', 'flag', '3']);
        $query->andWhere(['=', 'id_perkara', $id_perkara]);

        $query->andFilterWhere(['like', 'id_rencana_dakwaan', $this->id_rencana_dakwaan])
            ->andFilterWhere(['like', 'no_perkara', $this->no_perkara])
            ->andFilterWhere(['like', 'perpanjangan', $this->perpanjangan])
            ->andFilterWhere(['like', 'pengalihan', $this->pengalihan])
            ->andFilterWhere(['like', 'pencabutan', $this->pencabutan])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'dakwaan', $this->dakwaan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
