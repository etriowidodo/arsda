<?php

namespace app\modules\pdsold\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pdsold\models\PdmJaksaP16;
use yii\db\Query;


class PdmJaksaP16Search extends PdmJaksaP16 {
    public function rules() {
        return [
            [['no_urut'], 'integer'],
            [['id_perkara', 'id_jpp','id_p16', 'nip', 'nama', 'jabatan', 'pangkat'], 'safe'],
        ];
    }
    
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
    
    public function search2($id_perkara,$params) {
        $query = new Query;
        $query->select('*')
                ->from('pidum.pdm_jaksa_p16 ')
                ->where("id_perkara='" . $id_perkara . "'  ")
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
            'id_perkara' => $this->id_perkara,
//            'no_surat_p16a' => $this->no_surat_p16a,
//            'no_urut' => $this->no_urut,
        ]);

        $query->andFilterWhere(['like', 'nip', $this->nip])
                ->andFilterWhere(['like', 'nama', $this->nama])
                ->andFilterWhere(['like', 'jabatan', $this->jabatan])
                ->andFilterWhere(['like', 'pangkat', $this->pangkat]);
//                ->andFilterWhere(['like', 'peg_nama', $this->peg_nama])
//                ->andFilterWhere(['like', 'jabatan', $this->jabatan])
//                ->andFilterWhere(['like', 'pangkat', $this->pangkat]);

        return $dataProvider;
    }
}
?>
