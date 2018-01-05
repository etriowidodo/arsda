<?php

namespace app\modules\pdsold\models;

use app\modules\pdsold\models\PdmP51;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Session;

/**
 * PdmP51Search represents the model behind the search form about `app\modules\pidum\models\PdmP51`.
 */
class PdmP51Search extends PdmP51
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p51', 'id_perkara', 'dikeluarkan', 'tgl_dikeluarkan', 'id_tersangka', 'stat_kawin', 'ortu', 'tgl_jth_pidana', 'tgl_hkm_tetap', 'tambahan', 'percobaan', 'tgl_awal_coba', 'tgl_akhir_coba', 'syarat', 'id_penandatangan', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['denda', 'pokok'], 'number'],
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
    public function search($params)
    {
        $query = PdmP51::find();
        $session = new Session();
        $id = $session->get('id_perkara');
        $query->where = "flag != '3' and id_perkara='$id'";

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
            'tgl_dikeluarkan' => $this->tgl_dikeluarkan,
            'tgl_jth_pidana' => $this->tgl_jth_pidana,
            'tgl_hkm_tetap' => $this->tgl_hkm_tetap,
            'denda' => $this->denda,
            'pokok' => $this->pokok,
            'tgl_awal_coba' => $this->tgl_awal_coba,
            'tgl_akhir_coba' => $this->tgl_akhir_coba,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_p51', $this->id_p51])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'stat_kawin', $this->stat_kawin])
            ->andFilterWhere(['like', 'ortu', $this->ortu])
            ->andFilterWhere(['like', 'tambahan', $this->tambahan])
            ->andFilterWhere(['like', 'percobaan', $this->percobaan])
            ->andFilterWhere(['like', 'syarat', $this->syarat])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
