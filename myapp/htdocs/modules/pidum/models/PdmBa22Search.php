<?php

namespace app\modules\pidum\models;

use app\modules\pidum\models\PdmBa22;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Session;

/**
 * PdmBa22Search represents the model behind the search form about `app\modules\pidum\models\PdmBa22`.
 */
class PdmBa22Search extends PdmBa22 {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id_ba22', 'id_perkara', 'tgl_surat', 'lokasi', 'nip1', 'nama1', 'pangkat1', 'jabatan1', 'nip2', 'nama2', 'pangkat2', 'jabatan2', 'keperluan', 'dimusnahkan', 'flag', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['id_msstatdata', 'created_by', 'updated_by'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = PdmBa22::find();
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
            'id_msstatdata' => $this->id_msstatdata,
            'tgl_surat' => $this->tgl_surat,
            'created_by' => $this->created_by,
            'created_time' => $this->created_time,
            'updated_by' => $this->updated_by,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'id_ba22', $this->id_ba22])
                ->andFilterWhere(['like', 'id_perkara', $this->id_perkara])
                ->andFilterWhere(['like', 'lokasi', $this->lokasi])
                ->andFilterWhere(['like', 'nip1', $this->nip1])
                ->andFilterWhere(['like', 'nama1', $this->nama1])
                ->andFilterWhere(['like', 'pangkat1', $this->pangkat1])
                ->andFilterWhere(['like', 'jabatan1', $this->jabatan1])
                ->andFilterWhere(['like', 'nip2', $this->nip2])
                ->andFilterWhere(['like', 'nama2', $this->nama2])
                ->andFilterWhere(['like', 'pangkat2', $this->pangkat2])
                ->andFilterWhere(['like', 'jabatan2', $this->jabatan2])
                ->andFilterWhere(['like', 'keperluan', $this->keperluan])
                ->andFilterWhere(['like', 'dimusnahkan', $this->dimusnahkan])
                ->andFilterWhere(['like', 'flag', $this->flag])
                ->andFilterWhere(['like', 'created_ip', $this->created_ip])
                ->andFilterWhere(['like', 'updated_ip', $this->updated_ip]);

        return $dataProvider;
    }

}
