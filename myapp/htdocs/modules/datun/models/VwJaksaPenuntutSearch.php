<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\datun\models\VwJaksaPenuntut;
use yii\db\Query;

/**
 * VwJaksaPenuntutSearch represents the model behind the search form about `app\modules\pidum\models\VwJaksaPenuntut`.
 */
class VwJaksaPenuntutSearch extends VwJaksaPenuntut {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [['peg_instakhir', 'peg_nik', 'peg_nip', 'peg_nip_baru', 'peg_nama', 'jabat_tmt', 'jabatan', 'pangkat'], 'safe'],
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
        $query = VwJaksaPenuntut::find();

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
            'id' => $this->id,
            'jabat_tmt' => $this->jabat_tmt,
        ]);

        $query->andFilterWhere(['like', 'peg_instakhir', $this->peg_instakhir])
                ->andFilterWhere(['like', 'peg_nik', $this->peg_nik])
                ->andFilterWhere(['like', 'peg_nip', $this->peg_nip])
                ->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nip_baru])
                ->andFilterWhere(['like', 'peg_nama', $this->peg_nama])
                ->andFilterWhere(['like', 'jabatan', $this->jabatan])
                ->andFilterWhere(['like', 'pangkat', $this->pangkat]);

        return $dataProvider;
    }

    public function search2($params) {
        $query = new Query;
        $instaakhir = \Yii::$app->globalfunc->getSatker()->inst_satkerkd;
        $query->select('*')
                ->from('datun.vw_jaksa_penuntut ')
                ->where("peg_instakhir='" . $instaakhir . "' and upper(pangkat) LIKE upper('%jaksa%') ");
				//->orderBy('peg_nama');

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
            'id' => $this->id,
            'jabat_tmt' => $this->jabat_tmt,
        ]);

        $query->andFilterWhere(['like', 'peg_instakhir', $this->peg_instakhir])
                ->andFilterWhere(['like', 'peg_nik', $this->peg_nik])
                ->andFilterWhere(['like', 'peg_nip', $this->peg_nip])
                ->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nip_baru])
                ->andFilterWhere(['like', 'upper(peg_nama)', strtoupper($this->peg_nama)])
                ->andFilterWhere(['like', 'upper(jabatan)', strtoupper($this->jabatan)])
                ->andFilterWhere(['like', 'upper(pangkat)', strtoupper($this->pangkat)]);
//var_dump($query);exit;
//echo $query['string'];exit;
        return $dataProvider;
    }

}
