<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Pegawai2;
use yii\db\Query;

/**
 * PenandatanganSearch represents the model behind the search form about `app\modules\pengawasan\models\Penandatangan`.
 */
class Pegawai2Search extends Pegawai2
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nip', 'nama_penandatangan','pangkat_penandatangan','golongan_penandatangan','id_tingkat_wilayah','jabatan_penandatangan', 'kode_level'], 'safe'],
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
        $query = Pegawai::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nipbaru])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'gol_kd', $this->gol_kd])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'gol_pangkat2', $this->gol_pangkat2]);

        return $dataProvider;
    }


    public function searchPenandaTangan($params,$from_tabel)
    {
       $query = new Query;
       $query->select("nip, nama_penandatangan,jabatan_penandatangan,unitkerja_kd")
                ->from("was.penandatangan");
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

        $query->andFilterWhere(['like', 'upper(nip)',strtoupper($this->nip)])
            ->andFilterWhere(['like', 'upper(nama_penandatangan)',strtoupper($this->nama_penandatangan)]);

        return $dataProvider;
    }

}
