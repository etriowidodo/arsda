<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was1Pemeriksa;
use yii\db\Query;

/**
 * PemeriksaSearch represents the model behind the search form about `app\modules\pengawasan\models\Pemeriksa`.
 */
class Was1PemeriksaSearch extends Was1Pemeriksa
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pemeriksa','nip','peg_nik_baru','akronim','nama_pemeriksa','pangkat','golongan','jabatan','nama_penandatangan'], 'safe'],
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
        $var=str_split(($_SESSION['is_inspektur_irmud_riksa']));
        $query = Was1Pemeriksa::findBySql("select*from was.was_pemeriksa where irmud='".$var[1]."'");

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
            'id_pemeriksa' => $this->id_pemeriksa,
            'nip' => $this->nip,
            'peg_nik_baru' => $this->peg_nik_baru,
            'akronim' => $this->akronim,
            'nama_pemeriksa' => $this->nama_pemeriksa,
            'pangkat' => $this->pangkat,
            'golongan' => $this->golongan,
            'jabatan' => $this->jabatan,
            'nama_penandatangan' => $this->nama_penandatangan,
            
        ]);

        $query->andFilterWhere(['like', 'id_pemeriksa', $this->id_pemeriksa])
            ->andFilterWhere(['like', 'nip', $this->nip])
            ->andFilterWhere(['like', 'peg_nik_baru', $this->peg_nik_baru])
            ->andFilterWhere(['like', 'nama_pemeriksa', $this->nama_pemeriksa])
            ->andFilterWhere(['like', 'pangkat', $this->pangkat])
            ->andFilterWhere(['like', 'golongan', $this->golongan])
            ->andFilterWhere(['like', 'nama_penandatangan', $this->nama_penandatangan])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan]);

        return $dataProvider;
    }
	
	public function searchPenandaTangan($params,$from_tabel)
    {
       $query = new Query;
       $query->select("a.nip as nip,b.nama_penandatangan as nama_penandatangan,b.jabatan_penandatangan,b.pangkat_penandatangan as pangkat,b.golongan_penandatangan as golongan,c.nama as jabatan")
                ->from("was.penandatangan_surat a")
				->join("inner join","was.penandatangan b","a.unitkerja_kd=b.unitkerja_kd") 
				->join("left join","was.was_jabatan c","c.id_jabatan=a.id_jabatan") 
				->where("a.id_surat='".$from_tabel."'")
                ->orderBy('a.id_jabatan');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }//Was1PemeriksaSearch[nip]

        $query->andFilterWhere(['like', 'upper(a.nip)',strtoupper($params['Was1PemeriksaSearch']['nip'])])
            // ->orFilterWhere(['like', 'upper(b.nama_penandatangan)',strtoupper($params['Was1PemeriksaSearch']['nama_penandatangan'])])
            ->orFilterWhere(['like', 'upper(b.golongan_penandatangan)',strtoupper($params['Was1PemeriksaSearch']['golongan'])])
            ->orFilterWhere(['like', 'upper(jabatan)',strtoupper($params['Was1PemeriksaSearch']['jabata'])])
            ->andFilterWhere(['=', 'a.id_surat',$from_tabel]);

        return $dataProvider;
    }
	
    public function searchPenandaTanganpemeriksa($params,$from_tabel,$unitkerja_kd)
    {
       $query = new Query;
       $query1 = new Query;
       $query2 = new Query;
       $query1->select("a.id_jabatan,a.nip as nip,b.nama_penandatangan as nama_penandatangan,b.jabatan_penandatangan,b.pangkat_penandatangan as pangkat,b.golongan_penandatangan as golongan,c.nama as jabatan,b.unitkerja_kd")
                ->from("was.penandatangan_surat a")
                ->join("inner join","was.penandatangan b","a.unitkerja_kd=b.unitkerja_kd") 
                ->join("left join","was.was_jabatan c","c.id_jabatan=a.id_jabatan") 
                ->where("a.id_surat='".$from_tabel."'")
                ->andWhere("b.kode_level='28'")
                ->andWhere($unitkerja_kd)
                ->andWhere("substring(c.id_jabatan,1,1)='0'")//penampilkan penandatangan sendiri
                ->andWhere("a.nip='".$_SESSION['nik_user']."'")
                ->orderBy('a.id_jabatan');
       $query2->select("a.id_jabatan,a.nip as nip,b.nama_penandatangan as nama_penandatangan,b.jabatan_penandatangan,b.pangkat_penandatangan as pangkat,b.golongan_penandatangan as golongan,c.nama as jabatan,b.unitkerja_kd")
                ->from("was.penandatangan_surat a")
                ->join("inner join","was.penandatangan b","a.unitkerja_kd=b.unitkerja_kd") 
                ->join("left join","was.was_jabatan c","c.id_jabatan=a.id_jabatan") 
                ->where("a.id_surat='".$from_tabel."'")
                ->andWhere("b.kode_level='28'")
                ->andWhere($unitkerja_kd)
                ->andWhere("substring(c.id_jabatan,1,1)<>'0'")//penampilkan penandatangan AN/PLT/PLH
                ->andWhere("a.nip not in('".$_SESSION['nik_user']."')")
                ->orderBy('a.id_jabatan');
        $query=$query1->union($query2);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }//Was1PemeriksaSearch[nip]

        $query->andFilterWhere(['like', 'upper(a.nip)',strtoupper($params['Was1PemeriksaSearch']['nip'])])
            ->andFilterWhere(['like', 'upper(nama_penandatangan)',strtoupper($params['Was1PemeriksaSearch']['nama_penandatangan'])])
            ->andFilterWhere(['like', 'upper(b.golongan_penandatangan)',strtoupper($params['Was1PemeriksaSearch']['golongan'])])
            ->andFilterWhere(['like', 'upper(c.nama)',strtoupper($params['Was1PemeriksaSearch']['jabatan'])])
            // ->andFilterWhere($unitkerja_kd)
            ->andFilterWhere(['=','b.kode_level','28'])
            ->andFilterWhere(['=', 'a.id_surat',$from_tabel]);

        return $dataProvider;
    }

    public function searchPenandaTanganirmud($params,$from_tabel,$unitkerja_kd,$nip)
    {
       $query = new Query;
       $query1 = new Query;
       $query2 = new Query;
       $query1->select("a.id_jabatan,a.nip as nip,b.nama_penandatangan as nama_penandatangan,b.jabatan_penandatangan,b.pangkat_penandatangan as pangkat,b.golongan_penandatangan as golongan,c.nama as jabatan,b.unitkerja_kd")
                ->from("was.penandatangan_surat a")
                ->join("inner join","was.penandatangan b","a.unitkerja_kd=b.unitkerja_kd") 
                ->join("left join","was.was_jabatan c","c.id_jabatan=a.id_jabatan") 
                ->where("a.id_surat='".$from_tabel."'")
                ->andWhere("b.kode_level='44'")
                ->andWhere($unitkerja_kd)
                ->andWhere("a.nip='".$nip."'")
                ->andWhere("substring(c.id_jabatan,1,1)='0'")
                ->orderBy('a.id_jabatan');
       $query2->select("a.id_jabatan,a.nip as nip,b.nama_penandatangan as nama_penandatangan,b.jabatan_penandatangan,b.pangkat_penandatangan as pangkat,b.golongan_penandatangan as golongan,c.nama as jabatan,b.unitkerja_kd")
                ->from("was.penandatangan_surat a")
                ->join("inner join","was.penandatangan b","a.unitkerja_kd=b.unitkerja_kd") 
                ->join("left join","was.was_jabatan c","c.id_jabatan=a.id_jabatan") 
                ->where("a.id_surat='".$from_tabel."'")
                ->andWhere("b.kode_level='44'")
                ->andWhere($unitkerja_kd)
                ->andWhere("a.nip not in('".$nip."')")
                ->andWhere("substring(c.id_jabatan,1,1)<>'0'")
                ->orderBy('a.id_jabatan');
       $query=$query1->union($query2);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }//Was1PemeriksaSearch[nip]

        $query->andFilterWhere(['like', 'upper(a.nip)',strtoupper($params['Was1PemeriksaSearch']['nip'])])
            ->andFilterWhere(['like', 'upper(b.nama_penandatangan)',strtoupper($params['Was1PemeriksaSearch']['nama_penandatangan'])])
            ->andFilterWhere(['like', 'upper(b.golongan_penandatangan)',strtoupper($params['Was1PemeriksaSearch']['golongan'])])
            ->andFilterWhere(['like', 'upper(nama)',strtoupper($params['Was1PemeriksaSearch']['jabatan'])])
            // ->andFilterWhere([$unitkerja_kd])
            ->andFilterWhere(['=','b.kode_level','44'])
            ->andFilterWhere(['=', 'a.id_surat',$from_tabel]);

        return $dataProvider;
    }

    public function searchPenandaTanganinspektur($params,$from_tabel,$nip)
    {
       $query = new Query;
       $query1 = new Query;
       $query2 = new Query;
       $query1->select("a.id_jabatan,a.nip as nip,b.nama_penandatangan as nama_penandatangan,b.jabatan_penandatangan,b.pangkat_penandatangan as pangkat,b.golongan_penandatangan as golongan,c.nama as jabatan,b.unitkerja_kd")
                ->from("was.penandatangan_surat a")
                ->join("inner join","was.penandatangan b","a.unitkerja_kd=b.unitkerja_kd") 
                ->join("left join","was.was_jabatan c","c.id_jabatan=a.id_jabatan") 
                ->where("a.id_surat='".$from_tabel."'")
                ->andWhere("b.kode_level='7'")
                ->andWhere("substring(c.id_jabatan,1,1)<>'0'")
                ->andWhere("a.nip not in('".$nip."')")
                // ->andWhere($unitkerja_kd)
                ->orderBy('a.id_jabatan');
        $query2->select("a.id_jabatan,a.nip as nip,b.nama_penandatangan as nama_penandatangan,b.jabatan_penandatangan,b.pangkat_penandatangan as pangkat,b.golongan_penandatangan as golongan,c.nama as jabatan,b.unitkerja_kd")
                ->from("was.penandatangan_surat a")
                ->join("inner join","was.penandatangan b","a.unitkerja_kd=b.unitkerja_kd") 
                ->join("left join","was.was_jabatan c","c.id_jabatan=a.id_jabatan") 
                ->where("a.id_surat='".$from_tabel."'")
                ->andWhere("b.kode_level='7'")
                ->andWhere("substring(c.id_jabatan,1,1)='0'")
                ->andWhere("a.nip='".$nip."'")
                // ->andWhere($unitkerja_kd)
                ->orderBy('a.id_jabatan');
        $query=$query1->union($query2);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }//Was1PemeriksaSearch[nip]

        $query->andFilterWhere(['like', 'upper(a.nip)',strtoupper($params['Was1PemeriksaSearch']['nip'])])
            ->andFilterWhere(['like', 'upper(b.nama_penandatangan)',strtoupper($params['Was1PemeriksaSearch']['nama_penandatangan'])])
            ->andFilterWhere(['like', 'upper(b.golongan_penandatangan)',strtoupper($params['Was1PemeriksaSearch']['golongan'])])
            ->andFilterWhere(['like', 'upper(nama)',strtoupper($params['Was1PemeriksaSearch']['jabatan'])])
            ->andFilterWhere(['=','b.kode_level','7'])
            ->andFilterWhere(['=', 'a.id_surat',$from_tabel]);

        return $dataProvider;
    }
    
    
}
