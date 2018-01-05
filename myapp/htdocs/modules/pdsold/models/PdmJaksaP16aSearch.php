<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmJaksaP16a;
use yii\db\Query;


class PdmJaksaP16aSearch extends PdmJaksaP16a {
    
    public function rules() {
        return [
            [['no_urut'], 'integer'],
            [['no_register_perkara', 'no_surat_p16a', 'nip', 'nama', 'jabatan', 'keterangan', 'id_kejati', 'id_kejari', 'id_cabjari'], 'safe'],
        ];
    }
    
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    
    public function search($params) {
        $query = PdmJaksaP16a::find();

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
    
    
    public function search2($no_register_perkara,$params) {
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_jaksa_p16a ')
                ->where("no_register_perkara='" . $no_register_perkara . "'  ")
                ->orderBy('no_urut');

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
            'no_register_perkara' => $this->no_register_perkara,
            'no_surat_p16a' => $this->no_surat_p16a,
            'no_urut' => $this->no_urut,
        ]);

        $query->andFilterWhere(['like', 'nip', $this->nip])
                ->andFilterWhere(['like', 'nama', $this->nama])
                ->andFilterWhere(['like', 'jabatan', $this->jabatan])
                ->andFilterWhere(['like', 'pangkat', $this->pangkat]);
//var_dump($query);exit;
//echo $query['string'];exit;
        return $dataProvider;
    }
    
    
    
}