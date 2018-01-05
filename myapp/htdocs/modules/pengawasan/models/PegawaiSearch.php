<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Pegawai;
use app\modules\pengawasan\models\pemeriksa;
use yii\db\Query;
use yii\data\SqlDataProvider;

/**
 * PenandatanganSearch represents the model behind the search form about `app\modules\pengawasan\models\Penandatangan`.
 */
class PegawaiSearch extends Pegawai
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['peg_nip_baru', 'nama','jabatan', 'gol_kd', 'gol_pangkat2','jabatan_panjang','nama_penandatangan','nip','golongan','jabatan_penandatangan'], 'safe'],
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
    public function search($params,$from_tabel)
    {
        // $query = Pegawai::find();
        $query = new Query;
       $query->select("peg_nip_baru, nama, gol_kd, jabatan, gol_pangkat2, ref_jabatan_kd, jabatan_panjang")
                ->from("kepegawaian.kp_pegawai")
                // ->join("inner join","was.penandatangan b","a.peg_nip_baru=b.nip");
                 ->where("ref_jabatan_kd='7'")
                 ->orWhere("ref_jabatan_kd='44'")
                 ->orWhere("ref_jabatan_kd='28'")
                 ->orWhere("ref_jabatan_kd='3'")
                 ->orWhere("ref_jabatan_kd='5'")
                 ->andWhere("unitkerja_idk='1.6'")
                 ->orWhere("unitkerja_idk='2.6'")
                 ->orWhere("unitkerja_idk='3.6'")
                 ->andWhere("inst_satkerkd='".$_SESSION['inst_satkerkd']."'")
                 ->orderBy('ref_jabatan_kd');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'peg_nip_baru', $this->peg_nip_baru])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'gol_kd', $this->gol_kd])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'gol_pangkat2', $this->gol_pangkat2])
            ->andFilterWhere(['like', 'jabatan_panjang', $this->jabatan_panjang]);

        return $dataProvider;
    }


    public function searchPenandaTangan($params,$from_tabel)
    {
       $query = new Query;
       $query->select("peg_nip_baru, nama, gol_kd, jabatan, gol_pangkat2, ref_jabatan_kd, jabatan_panjang,unitkerja_kd")
                ->from("kepegawaian.kp_pegawai")
                // ->join("inner join","was.penandatangan b","a.peg_nip_baru=b.nip");
                 ->where("ref_jabatan_kd='7'")
                 ->orWhere("ref_jabatan_kd='44'")
                 ->orWhere("ref_jabatan_kd='28'")
                 ->orWhere("ref_jabatan_kd='3'")
                 ->orWhere("ref_jabatan_kd='5'")
                 ->andWhere("unitkerja_idk='1.6'")
                 ->orWhere("unitkerja_idk='2.6'")
                 ->orWhere("unitkerja_idk='3.6'")
                 ->andWhere("inst_satkerkd='".$_SESSION['inst_satkerkd']."'")
                 ->orderBy('ref_jabatan_kd');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'upper(peg_nip_baru)',$this->peg_nip_baru])
            // ->andFilterWhere(['like', 'upper(nama)',strtoupper($params['PegawaiSearch']['cari'])]);
            ->andFilterWhere(['like', 'upper(nama)',strtoupper($this->nama)])
            ->andFilterWhere(['like', 'upper(gol_kd)',strtoupper($this->gol_kd)])
            ->andFilterWhere(['like', 'upper(jabatan)',strtoupper($this->jabatan)])
            ->andFilterWhere(['like', 'upper(gol_pangkat2)',strtoupper($this->gol_pangkat2)])
            ->andFilterWhere(['like', 'upper(jabatan_panjang)',strtoupper($this->jabatan_panjang)]);

        return $dataProvider;
    }

    public function searchPenandaTanganwas1riksa($params,$from_tabel,$unitkerja_kd)
    {
       $q1  = htmlspecialchars($params['nip'], ENT_QUOTES);
       $query = new Query;
       $query1 = new Query;
       $query2 = new Query;
       
       $query="select*from (select*from was.v_penandatangan_was1 where kode_level='28' and nip='".$_SESSION['nik_user']."' and substring(id_jabatan,1,1)='0' 
        union all
        select*from was.v_penandatangan_was1 where kode_level='28' and ".$unitkerja_kd." and nip<>'".$_SESSION['nik_user']."' and substring(id_jabatan,1,1)<>'0')a";
        // if($q1!=''){
        $query .=" where  upper(a.nip) like '%".strtoupper($_GET['PegawaiSearch']['nip'])."%'";
        $query .="  And  upper(a.nama_penandatangan) like '%".strtoupper($_GET['PegawaiSearch']['nama_penandatangan'])."%'";
        $query .="  And  upper(a.jabatan_penandatangan) like '%".strtoupper($_GET['PegawaiSearch']['jabatan_penandatangan'])."%'";
        // $query .="  And  upper(a.golongan) like '%".strtoupper($_GET['PegawaiSearch']['golongan'])."%'";
        $query .="  And  upper(a.jabatan) like '%".strtoupper($_GET['PegawaiSearch']['jabatan'])."%'";

        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
          'pageSize' => 10,
      ]
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }

        
        return $dataProvider;
    }
    public function searchPenandaTanganwas1irmud($params,$from_tabel,$unitkerja_kd,$nip){
       $q1  = htmlspecialchars($params['nip'], ENT_QUOTES);
       $query = new Query;
       $query1 = new Query;
       $query2 = new Query;
       //and nip='".$nip."' and substring(id_jabatan,1,1)='0'
       // and substring(id_jabatan,1,1)<>'0'
       $query="select*from (select*from was.v_penandatangan_was1 where kode_level='44'  
        union all
        select*from was.v_penandatangan_was1 where kode_level='44' and ".$unitkerja_kd." and nip<>'".$nip."')a";
        // if($q1!=''){
        $query .=" where  upper(a.nip) like '%".strtoupper($_GET['PegawaiSearch']['nip'])."%'";
        $query .="  And  upper(a.nama_penandatangan) like '%".strtoupper($_GET['PegawaiSearch']['nama_penandatangan'])."%'";
        $query .="  And  upper(a.jabatan_penandatangan) like '%".strtoupper($_GET['PegawaiSearch']['jabatan_penandatangan'])."%'";
        // $query .="  And  upper(a.jabatan_penandatangan) like '%".strtoupper($_GET['PegawaiSearch']['golongan'])."%'";
        $query .="  And  upper(a.jabatan) like '%".strtoupper($_GET['PegawaiSearch']['jabatan'])."%'";

        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
          'pageSize' => 10,
      ]
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }

        
        return $dataProvider;

    }
  public function searchPenandaTanganwas1inspektur($params,$from_tabel,$nip){
       $q1  = htmlspecialchars($params['nip'], ENT_QUOTES);
       $query = new Query;
       $query1 = new Query;
       $query2 = new Query;
       
       $query="select*from (select*from was.v_penandatangan_was1 where kode_level='7' and nip='".$nip."' and substring(id_jabatan,1,1)='0' 
        union all
        select*from was.v_penandatangan_was1 where kode_level='7' and nip<>'".$nip."' and substring(id_jabatan,1,1)<>'0')a";
        // if($q1!=''){
        $query .=" where  upper(a.nip) like '%".strtoupper($_GET['PegawaiSearch']['nip'])."%'";
        $query .="  And  upper(a.nama_penandatangan) like '%".strtoupper($_GET['PegawaiSearch']['nama_penandatangan'])."%'";
        $query .="  And  upper(a.golongan) like '%".strtoupper($_GET['PegawaiSearch']['golongan'])."%'";
        $query .="  And  upper(a.jabatan_penandatangan) like '%".strtoupper($_GET['PegawaiSearch']['jabatan_penandatangan'])."%'";
        $query .="  And  upper(a.jabatan) like '%".strtoupper($_GET['PegawaiSearch']['jabatan'])."%'";

        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
          'pageSize' => 10,
      ]
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }

        
        return $dataProvider;

    }

    public function searchPenandaTanganspwas1($params,$from_tabel)/*spwas1*/
    {
       $query = new Query;
       $query="select a.nip as nip,b.nama_penandatangan as nama_penandatangan,b.jabatan_penandatangan,b.pangkat_penandatangan as pangkat,b.golongan_penandatangan as golongan,c.nama as jabatan,c.id_jabatan
           from was.penandatangan_surat a
            inner join was.penandatangan b on a.unitkerja_kd=b.unitkerja_kd
            left join was.was_jabatan c on c.id_jabatan=a.id_jabatan
            where a.id_surat='".$from_tabel."'";
       // $query->select("a.nip as nip,b.nama_penandatangan as nama_penandatangan,b.jabatan_penandatangan,b.pangkat_penandatangan as pangkat,b.golongan_penandatangan as golongan,c.nama as jabatan")
       //          ->from("was.penandatangan_surat a")
       //          ->join("inner join","was.penandatangan b","a.unitkerja_kd=b.unitkerja_kd") 
       //          ->join("left join","was.was_jabatan c","c.id_jabatan=a.id_jabatan") 
       //          ->where("a.id_surat='".$from_tabel."'")
       //          ->orderBy('a.id_jabatan');
            if($_GET['PegawaiSearch']['nip']!=''){
                $query .="  And  upper(a.nip) like '%".strtoupper($_GET['PegawaiSearch']['nip'])."%'";
            }
            if($_GET['PegawaiSearch']['nama_penandatangan']!=''){
                $query .="  And  upper(b.nama_penandatangan) like '%".strtoupper($_GET['PegawaiSearch']['nama_penandatangan'])."%'";
            }
            if($_GET['PegawaiSearch']['jabatan_penandatangan']!=''){
                $query .="  And  upper(b.jabatan_penandatangan) like '%".strtoupper($_GET['PegawaiSearch']['jabatan_penandatangan'])."%'";
            }
            if($_GET['PegawaiSearch']['jabatan']!=''){
                $query .="  And  upper(c.nama) like '%".strtoupper($_GET['PegawaiSearch']['jabatan'])."%'";
            }
        // // $query .="  And  upper(a.golongan) like '%".strtoupper($_GET['PegawaiSearch']['golongan'])."%'";

        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 10,
      ]
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }

        
        return $dataProvider;
    }

}
