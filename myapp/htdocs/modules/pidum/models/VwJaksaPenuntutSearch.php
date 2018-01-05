<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pidum\models\VwJaksaPenuntut;
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
                ->from('pidum.vw_jaksa_penuntut ')
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
	
	
	public function search16a($params) {
		$id_perkara = Yii::$app->session->get('id_perkara');
		
        $query = new Query;
        
        $query->select('nip as peg_nip,nip as peg_nip_baru,nama as peg_nama,pangkat,jabatan')
                ->from('pidum.pdm_jaksa_p16 ')
                ->where("id_perkara='".$id_perkara."' ");
			

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

        $query->andFilterWhere(['like', 'peg_nip_baru', $this->peg_instakhir])
                ->andFilterWhere(['like', 'peg_nik', $this->peg_nik])
                ->andFilterWhere(['like', 'nip', $this->peg_nip])
                ->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nip_baru])
                ->andFilterWhere(['like', 'upper(nama)', strtoupper($this->peg_nama)])
                ->andFilterWhere(['like', 'upper(jabatan)', strtoupper($this->jabatan)])
                ->andFilterWhere(['like', 'upper(pangkat)', strtoupper($this->pangkat)]);

        return $dataProvider;
    }


    public function search16a_new($params) {
        $no_register_perkara = Yii::$app->session->get('no_register_perkara');

        $no_p16a = Yii::$app->globalfunc->GetLastP16a($no_register_perkara)->no_surat_p16a;
        
        $query = new Query;
        
        $query->select('nip as peg_nip, nip ,nip as peg_nip_baru,nama as peg_nama, nama,pangkat,jabatan, no_surat_p16a, no_urut')
                ->from('pidum.pdm_jaksa_p16a ')
                ->where("no_register_perkara='".$no_register_perkara."' and no_surat_p16a='".$no_p16a."' ");
            

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);



        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        /*$query->andFilterWhere([
            'id' => $this->id,
            'jabat_tmt' => $this->jabat_tmt,
        ]);*/

        $query->andFilterWhere(['like', 'nip', $this->peg_nip])
                ->andFilterWhere(['like', 'upper(nama)', strtoupper($this->peg_nama)])
                ->andFilterWhere(['like', 'upper(jabatan)', strtoupper($this->jabatan)])
                ->andFilterWhere(['like', 'upper(pangkat)', strtoupper($this->pangkat)]);
        return $dataProvider;
    }

    public function searchPegawaiSatker($params) {
        $kode = Yii::$app->session->get('inst_satkerkd');
        
        $query = new Query;
        
        $query->select('peg_nip_baru as peg_nip,peg_nip_baru as peg_nip_baru,nama as peg_nama,gol_pangkat2 as pangkat,jabatan')
                ->from('kepegawaian.kp_pegawai  ')
                ->where("inst_satkerkd='".$kode."' ")
                ->orderBy("ref_jabatan_kd");
            

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        /*$query->andFilterWhere([
            'id' => $this->id,
            'jabat_tmt' => $this->jabat_tmt,
        ]);*/

        $query->andFilterWhere(['like', 'nip', $this->peg_nip_baru])
                ->andFilterWhere(['like', 'upper(nama)', strtoupper($this->peg_nama)])
                ->andFilterWhere(['like', 'upper(jabatan)', strtoupper($this->jabatan)])
                ->andFilterWhere(['like', 'upper(pangkat)', strtoupper($this->pangkat)]);

        return $dataProvider;
    }

    public function searchjaksaba5($params) {
        $no_register_perkara = Yii::$app->session->get('no_register_perkara');
        
        $query = new Query;
        
        $query->select('nip as peg_nip,nip as peg_nip_baru,nama as peg_nama,pangkat,jabatan')
                ->from('pidum.pdm_ba5_jaksa ')
                ->where("no_register_perkara='".$no_register_perkara."' ");
            

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        /*$query->andFilterWhere([
            'id' => $this->id,
            'jabat_tmt' => $this->jabat_tmt,
        ]);*/

        $query->andFilterWhere(['like', 'nip', $this->peg_nip])
                ->andFilterWhere(['like', 'upper(nama)', strtoupper($this->peg_nama)])
                ->andFilterWhere(['like', 'upper(jabatan)', strtoupper($this->jabatan)])
                ->andFilterWhere(['like', 'upper(pangkat)', strtoupper($this->pangkat)]);

        return $dataProvider;
    }

    public function searchttd($params) {
        $no_register_perkara = Yii::$app->session->get('no_register_perkara');
        $inst_satkerkd = Yii::$app->session->get('inst_satkerkd');
        
        $query1 = new Query;
        $query1->select('nip as peg_nip,nip as peg_nip_baru,nama as peg_nama,pangkat,jabatan')
                ->from('pidum.pdm_jaksa_p16a ')
                ->where("no_register_perkara='".$no_register_perkara."' ");

        $query2 = new Query;
        $query2->select('peg_nip_baru as peg_nip,peg_nip_baru as peg_nip_baru,nama as peg_nama,gol_pangkat2 as pangkat,jabatan')
                ->from('kepegawaian.kp_pegawai ')
                ->where("inst_satkerkd='".$inst_satkerkd."' and ref_jabatan_kd in('10','11','22','21','1','3') ");
            

        $query = new Query;

        $query->select('*')
                ->from([$query1->union($query2)]);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        /*$query->andFilterWhere([
            'id' => $this->id,
            'jabat_tmt' => $this->jabat_tmt,
        ]);*/

        $query->andFilterWhere(['like', 'nip', $this->peg_nip])
                ->andFilterWhere(['like', 'upper(nama)', strtoupper($this->peg_nama)])
                ->andFilterWhere(['like', 'upper(jabatan)', strtoupper($this->jabatan)])
                ->andFilterWhere(['like', 'upper(pangkat)', strtoupper($this->pangkat)]);

        return $dataProvider;
    }

}
