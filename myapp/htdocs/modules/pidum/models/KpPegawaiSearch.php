<?php

namespace app\modules\pidum\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Session;

/**
 * KpPegwaiSearch represents the model behind the search form about `app\models\KpPegawai`.
 */
class KpPegawaiSearch extends KpPegawai
{
    public $inst_nama;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['peg_nip_baru','nama','gol_pangkat2'], 'safe']
            //[['peg_nik', 'peg_nip', 'peg_nrp', 'peg_nama', 'peg_gelar', 'peg_tgllahir', 'peg_tgllahir', 'peg_jender', 'peg_agama', 'peg_status', 'peg_instakhir_tmt', 'peg_jbtakhirstk_es', 'peg_golakhir', 'peg_nip_baru'], 'safe'],
            //[['peg_jnspeg', 'pns_jnsjbtfungsi', 'peg_instakhir_jns', 'peg_jbtakhirstk', 'peg_jbtakhirjns', 'peg_jbtakhirfs'], 'number'],
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
        $query = KpPegawai::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
			'pageSize' => 10,
			],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'peg_tgllahir' => $this->peg_tgllahir,
            'peg_jnspeg' => $this->peg_jnspeg,
            'pns_jnsjbtfungsi' => $this->pns_jnsjbtfungsi,
            'peg_instakhir_tmt' => $this->peg_instakhir_tmt,
            'peg_instakhir_jns' => $this->peg_instakhir_jns,
            'peg_jbtakhirstk' => $this->peg_jbtakhirstk,
            'peg_jbtakhirjns' => $this->peg_jbtakhirjns,
            'peg_jbtakhirfs' => $this->peg_jbtakhirfs,
            
        ]);

        $query->andFilterWhere(['like', 'peg_nik', $this->peg_nik])
            ->andFilterWhere(['like', 'peg_nip', $this->peg_nip])
            ->andFilterWhere(['like', 'peg_nrp', $this->peg_nrp])
           // ->andFilterWhere(['like', 'lower(peg_nama)', strtolower($this->peg_nama)])
            ->andFilterWhere(['like', 'peg_gelar', $this->peg_gelar])
            ->andFilterWhere(['like', 'peg_tmplahirkab', $this->peg_tmplahirkab])
            ->andFilterWhere(['like', 'peg_jender', $this->peg_jender])
            ->andFilterWhere(['like', 'peg_agama', $this->peg_agama])
            ->andFilterWhere(['like', 'peg_status', $this->peg_status])
            ->andFilterWhere(['like', 'peg_instakhir', $this->peg_instakhir])
            ->andFilterWhere(['like', 'peg_jbtakhirstk_es', $this->peg_jbtakhirstk_es])
            ->andFilterWhere(['like', 'peg_golakhir', $this->peg_golakhir])
            ->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nip_baru]);

        return $dataProvider;
    }
    
    public function searchPegawai($params)
    {
        $query = new Query;
        $query->select('*')
                ->from('was.v_riwayat_jabatan1')
				->where("inst_satkerkd='".$_SESSION['inst_satkerkd']."'");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
			'pageSize' => 10,
			],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

     /*   $query->andFilterWhere([
            'id' => $this->id,
            
        ]);*/

        $query->andFilterWhere(['like', 'lower(peg_nik)', strtolower($this->peg_nik)])
              ->andFilterWhere(['like', 'lower(peg_nip)', strtolower($this->peg_nip)])
              ->andFilterWhere(['like', 'lower(inst_satkerkd)', strtolower($_SESSION['inst_satkerkd'])])
              ->andFilterWhere(['like', 'lower(peg_nip_baru)', strtolower($this->peg_nip_baru)]);
			  
              //->andFilterWhere(['like', 'lower(peg_nama)', strtolower($this->peg_nama)]);
          //  ->andFilterWhere(['like', 'jabat_tmt', $this->jabat_tmt])
              // ->andFilterWhere(['like', 'jabatan', $this->jabatan]);
            

        return $dataProvider;
    }

    public function searchPegawai2($params)
    {
        $query = new Query;
        $query->select('*')
                ->from('was.v_penandatangan');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
      'pagination' => [
      'pageSize' => 10,
      ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

     /*   $query->andFilterWhere([
            'id' => $this->id,
            
        ]);*/

        $query->andFilterWhere(['like', 'lower(peg_nik)', strtolower($this->peg_nik)])
              ->andFilterWhere(['like', 'lower(peg_nip)', strtolower($this->peg_nip)])
              ->andFilterWhere(['like', 'lower(peg_nip_baru)', strtolower($this->peg_nip_baru)]);
              //->andFilterWhere(['like', 'lower(peg_nama)', strtolower($this->peg_nama)]);
          //  ->andFilterWhere(['like', 'jabat_tmt', $this->jabat_tmt])
              // ->andFilterWhere(['like', 'jabatan', $this->jabatan]);
            

        return $dataProvider;
    }

    public function getPewagai($params){
        $query = new Query;
        // $query->select('*')
        //         ->from('was.v_riwayat_jabatan');

       // $query = KpPegawai::find()->joinWith(['kepegawaian.kp_inst_satker']);
        // $query->select('tersangka.id_tersangka as id, tersangka.nama as nama,tsk.id_perkara')
        $query->select('*')
                    ->from('was.v_riwayat_jabatan a, kepegawaian.kp_inst_satker b')
                    ->where("b.inst_satkerkd = a.peg_instakhir")
                    ->all();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
            'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

         $query->andFilterWhere(['like', 'lower(peg_nik)', strtolower($this->peg_nik)])
              ->andFilterWhere(['like', 'lower(peg_nip)', strtolower($this->peg_nip)])
              ->andFilterWhere(['like', 'lower(peg_nip_baru)', strtolower($this->peg_nip_baru)]);
              //->andFilterWhere(['like', 'lower(peg_nama)', strtolower($this->peg_nama)]);
          //  ->andFilterWhere(['like', 'jabat_tmt', $this->jabat_tmt])
              // ->andFilterWhere(['like', 'jabatan', $this->jabatan])
              // ->andFilterWhere(['like', 'lower(inst_nama)', strtolower($this->inst_nama)]);
         return $dataProvider;

    }
    
     public function searchPegawaiTtd($peg_nik,$peg_id_jabatan)
    {
        $query = new Query;
        $query->select('*')
                ->from('was.v_riwayat_jabatan')
                ->where("id= :id",[':id' => $peg_id_jabatan ])
                ->andWhere("peg_nik= :pegNik",[':pegNik' => $peg_nik ])
             //   ->asArray()
                ->one();
        $query = static::findBySql('select * from was.v_riwayat_jabatan where id= :id and peg_nik= :pegNik', [':id' => $peg_id_jabatan, ':pegNik' => $peg_nik])->asArray()->one();

        return  $query;
        

     
        }


      public function searchSaksi($params,$kode) {
        

        //return $kode;exit;
        $query = new Query;
        
        $query->select('peg_nip_baru, nama as peg_nama,gol_pangkat2 as pangkat,jabatan')
              ->from('kepegawaian.kp_pegawai')
              ->where(" inst_satkerkd='".$kode."' ");

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
        $query->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nip_baru]);
       /* $query->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nip])
                ->andFilterWhere(['like', 'upper(nama)', strtoupper($this->peg_nama)])
                ->andFilterWhere(['like', 'upper(jabatan)', strtoupper($this->jabatan)])
                ->andFilterWhere(['like', 'upper(pangkat)', strtoupper($this->pangkat)]);
*/
        return $dataProvider;
    }
    
    public function searchPeg($kode_kejati,$params){
        
        $query = new Query;
        $query->select('*')
                ->from('kepegawaian.kp_pegawai')
                ->where("inst_satkerkd='" . $kode_kejati . "'  ");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
//        echo '<pre>';print_r($dataProvider);exit();
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'inst_satkerkd' => $this->inst_satkerkd,
//            'nama' => $this->nama,
//            'gol_pangkat2' => $this->gol_pangkat2,
        ]);

        $query->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nip_baru])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'gol_pangkat2', $this->gol_pangkat2]);

        return $dataProvider;
    }
    
}