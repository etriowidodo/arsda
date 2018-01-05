<?php

namespace app\modules\pidsus\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * KpPegwaiSearch represents the model behind the search form about `app\models\KpPegawai`.
 */
class KpPegawaiSearch extends KpPegawai
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['peg_nik', 'peg_nip', 'peg_nrp', 'peg_nama', 'peg_gelar', 'peg_marga', 'peg_tmplahirkab', 'peg_tmplahirprov', 'peg_tgllahir', 'peg_jender', 'peg_agama', 'peg_status', 'peg_instakhir', 'peg_instakhir_tmt', 'peg_jbtakhirstk_tmt', 'peg_jbtakhirstk_es', 'peg_jbtakhirfs_tmt', 'peg_golakhir', 'peg_golakhir_tmt', 'peg_gelar_depan', 'id_cabang', 'peg_nip_baru'], 'safe'],
            [['peg_jnspeg', 'pns_jnsjbtfungsi', 'peg_instakhir_jns', 'peg_jbtakhirstk', 'peg_jbtakhirjns', 'peg_jbtakhirfs', 'peg_golakhir_mkth', 'peg_golakhir_mkbl'], 'number'],
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
            'peg_jbtakhirstk_tmt' => $this->peg_jbtakhirstk_tmt,
            'peg_jbtakhirfs' => $this->peg_jbtakhirfs,
            'peg_jbtakhirfs_tmt' => $this->peg_jbtakhirfs_tmt,
            'peg_golakhir_tmt' => $this->peg_golakhir_tmt,
            'peg_golakhir_mkth' => $this->peg_golakhir_mkth,
            'peg_golakhir_mkbl' => $this->peg_golakhir_mkbl,
        ]);

        $query->andFilterWhere(['like', 'peg_nik', $this->peg_nik])
            ->andFilterWhere(['like', 'peg_nip', $this->peg_nip])
            ->andFilterWhere(['like', 'peg_nrp', $this->peg_nrp])
            ->andFilterWhere(['like', 'peg_nama', $this->peg_nama])
            ->andFilterWhere(['like', 'peg_gelar', $this->peg_gelar])
            ->andFilterWhere(['like', 'peg_marga', $this->peg_marga])
            ->andFilterWhere(['like', 'peg_tmplahirkab', $this->peg_tmplahirkab])
            ->andFilterWhere(['like', 'peg_tmplahirprov', $this->peg_tmplahirprov])
            ->andFilterWhere(['like', 'peg_jender', $this->peg_jender])
            ->andFilterWhere(['like', 'peg_agama', $this->peg_agama])
            ->andFilterWhere(['like', 'peg_status', $this->peg_status])
            ->andFilterWhere(['like', 'peg_instakhir', $this->peg_instakhir])
            ->andFilterWhere(['like', 'peg_jbtakhirstk_es', $this->peg_jbtakhirstk_es])
            ->andFilterWhere(['like', 'peg_golakhir', $this->peg_golakhir])
            ->andFilterWhere(['like', 'peg_gelar_depan', $this->peg_gelar_depan])
            ->andFilterWhere(['like', 'id_cabang', $this->id_cabang])
            ->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nip_baru]);

        return $dataProvider;
    }
    public function searchBySatker($params,$idSatker)
    {
    	if($idSatker===''){
    		$query = KpPegawai::find();
    	}
    	else  $query = KpPegawai::find()->where(['peg_instakhir'=>'09.01']) ;
    	//$query = KpPegawai::find();
    	//  $query = PdsDikSurat::find()->where(['id_jenis_surat'=>$idJenisSurat])
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
    	->andFilterWhere(['like', 'lower(peg_nama)', strtolower($this->peg_nama)])
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
    	->from('was.v_riwayat_jabatan');
    
    	$dataProvider = new ActiveDataProvider([
    			'query' => $query,
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
    
    	$query->andFilterWhere(['like', 'peg_nik', $this->peg_nik])
    	->andFilterWhere(['like', 'peg_nip', $this->peg_nip])
    	->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nip_baru])
    	->andFilterWhere(['like', 'peg_nama', $this->peg_nama]);
    	//  ->andFilterWhere(['like', 'jabat_tmt', $this->jabat_tmt])
    	//   ->andFilterWhere(['like', 'jabatan', $this->jabatan]);
    
    
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
}