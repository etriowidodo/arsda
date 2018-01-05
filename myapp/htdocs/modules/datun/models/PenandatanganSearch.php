<?php

namespace app\modules\datun\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\datun\models\Penandatangan;
use yii\web\Session;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * PdmPenandatanganSearch represents the model behind the search form about `app\modules\pidum\models\PdmPenandatangan`.
 */
class PenandatanganSearch extends Penandatangan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [ //bowo 30 mei 2016 #menambahkan field peg_nip_baru
            [['peg_nik', 'nama', 'pangkat', 'jabatan', 'keterangan', 'is_active', 'flag', 'id_ttd', 'peg_nip_baru'], 'safe'],
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
    public function search($id_ttd,$params)
    {
        $query = Penandatangan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andWhere(['!=', 'flag', '3']);
        // $query->andwhere(['=', 'id_ttd', $id_ttd]);

        $query->andFilterWhere(['like', 'peg_nik', $this->peg_nik])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'pangkat', $this->pangkat])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'is_active', $this->is_active])
            ->andFilterWhere(['like', 'flag', $this->flag])
            ->andFilterWhere(['like', 'id_ttd', $this->id_ttd])
			//bowo
			->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nip_baru]);

        return $dataProvider;
    }

    public function searchPenandaTangan($params) {
        $query = new Query;
        $query->select('pdm_penandatangan.peg_nik, pdm_penandatangan.peg_nip_baru, pdm_penandatangan.nama, pdm_penandatangan.pangkat, pdm_penandatangan.jabatan, pdm_penandatangan.keterangan, pdm_penandatangan.is_active, pdm_penandatangan.flag')
                ->from('datun.m_penandatangan')
                ->where("pdm_penandatangan.is_active = '1'::bpchar AND pdm_penandatangan.flag <> '3'");
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'peg_nik' => $this->peg_nik,
			'peg_nip_baru' => $this->peg_nip_baru,
           
        ]);

        $query->andFilterWhere(['like', 'peg_nik', $this->peg_nik])
                ->andFilterWhere(['like', 'id_ttd', $this->id_ttd])
				->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nip_baru])
                ->andFilterWhere(['like', 'upper(pdm_penandatangan.nama)', strtoupper($this->nama)]);
        return $dataProvider;
    }
}
