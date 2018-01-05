<?php

namespace app\modules\pidum\models;

use app\modules\pidum\models\PdmP52;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Session;

/**
 * PdmP52Search represents the model behind the search form about `app\modules\pidum\models\PdmP52`.
 */
class PdmP52Search extends PdmP52
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_p52', 'id_perkara', 'dikeluarkan', 'tgl_dikeluarkan', 'id_tersangka', 'stat_kawin', 'ortu', 'tgl_jth_pidana', 'no_put_penjara', 'tgl_put_penjara', 'syarat_bina', 'tgl_lepas_syarat', 'tgl_pelaksanaan', 'kejari_pengawas', 'balai_bapas', 'keterangan', 'id_penandatangan', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
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
        $query = PdmP52::find();
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
            'tgl_put_penjara' => $this->tgl_put_penjara,
            'tgl_lepas_syarat' => $this->tgl_lepas_syarat,
            'tgl_pelaksanaan' => $this->tgl_pelaksanaan,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_p52', $this->id_p52])
            ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
            ->andFilterWhere(['like', 'dikeluarkan', $this->dikeluarkan])
            ->andFilterWhere(['like', 'id_tersangka', $this->id_tersangka])
            ->andFilterWhere(['like', 'stat_kawin', $this->stat_kawin])
            ->andFilterWhere(['like', 'ortu', $this->ortu])
            ->andFilterWhere(['like', 'no_put_penjara', $this->no_put_penjara])
            ->andFilterWhere(['like', 'syarat_bina', $this->syarat_bina])
            ->andFilterWhere(['like', 'kejari_pengawas', $this->kejari_pengawas])
            ->andFilterWhere(['like', 'balai_bapas', $this->balai_bapas])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'id_penandatangan', $this->id_penandatangan])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'created_ip', $this->created_ip])
            ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }
}
