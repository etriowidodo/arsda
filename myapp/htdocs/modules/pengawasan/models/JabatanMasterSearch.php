<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\JabatanMaster;
use yii\db\Query;

/**
 * InspekturModelSearch represents the model behind the search form about `app\modules\pengawasan\models\InspekturModel`.
 */
class JabatanMasterSearch extends JabatanMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_jabatan'], 'string'],
            [['nama', 'akronim'], 'safe'],
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
        $query = JabatanMaster::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id_jabatan' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id_jabatan' => $this->id_jabatan,
            'nama' => $this->nama,
            'akronim' => $this->nama,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'akronim', $this->akronim]);

        return $dataProvider;
    }

    public function searchJabatan($params,$from_tabel)
    {
       $query = new Query;
       $query->select("id_jabatan, nama,akronim")
                ->from("was.was_jabatan")
                ->orderBy("id_jabatan");
                // ->join("inner join","was.penandatangan b","a.peg_nip_baru=b.nip");
                 // ->where("ref_jabatan_kd='7'")
                 // ->orWhere("ref_jabatan_kd='44'")
                 // ->orWhere("ref_jabatan_kd='28'")
                 // ->orWhere("ref_jabatan_kd='3'")
                 // ->orWhere("ref_jabatan_kd='5'")
                 // ->andWhere("unitkerja_idk='1.6'")
                 // ->orWhere("unitkerja_idk='2.6'")
                 // ->orWhere("unitkerja_idk='3.6'")
                 // ->andWhere("inst_satkerkd='".$_SESSION['inst_satkerkd']."'")
                 // ->orderBy('ref_jabatan_kd');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'upper(id_jabatan)',strtoupper($params['id_jabatanSearch']['cari'])])
            ->andFilterWhere(['like', 'upper(nama)',strtoupper($this->nama)]);

        return $dataProvider;
    }
}
