<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was1;
use app\modules\pengawasan\models\WasRiksaindex;
use yii\db\Query;
use yii\data\SqlDataProvider;
use yii\db\Command;

/**
 * Was1Search represents the model behind the search form about `app\modules\pengawasan\models\Was1`.
 */
class Was1Search extends Was1
{
    /**
     * @inheritdoc
     */
    public $cari;
    public function rules()
    {
        return [
            [['no_register','id_tingkat','id_kejati','id_kejari','id_cabjari',  'no_register', 'was1_kesimpulan', 'was1_lampiran','was1_perihal', 'was1_analisa','was1_permasalahan', 'was1_narasi_awal', 'nip_penandatangan','nama_penandatangan', 'pangkat_penandatangan', 'golongan_penandatangan', 'jabatan_penandatangan', 'data','was1_tgl_surat','no_surat','tgl_cetak'], 'safe'],
            [['id_saran','id_level_was1','was1_dari','was1_kepada'], 'integer'],
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
	$query = new Query;
        //$query = Was1::find();
		$query->select('b.*,c.*')
                ->from('was.lapdu a')
                ->innerjoin('was.was1 b on (a.no_register=b.no_register)')
                ->leftjoin('was.saran_was1 c on (b.id_saran=c.id_saran_was1)')
				->where(['b.no_register'=> $_SESSION['was_register'],'is_inspektur_irmud_riksa'=>$_SESSION['is_inspektur_irmud_riksa']])
				->orderBy(' b.id_level_was1 desc');
                
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // $query->andFilterWhere([
        //     'tgl_was_1' => $this->tgl_was_1,
        //     'hasil_kesimpulan' => $this->hasil_kesimpulan,
        //     'saran' => $this->saran,
        //     'sebab_tdk_dilanjuti' => $this->sebab_tdk_dilanjuti,
        //    // 'flag != 0' => $this->flag,
        //     'created_by' => $this->created_by,
        //     'created_time' => $this->created_time,
        //     'updated_by' => $this->updated_by,
        //     'updated_time' => $this->updated_time,
        // ]);
        // $query->andFilterWhere(['!=', 'flag', '3']);
        // $query->andFilterWhere(['like', 'id_was_1', $params['Was1Search']['cari']])
        //     ->orFilterWhere(['like', 'inst_satkerkd', $params['Was1Search']['cari']])
        //     ->orFilterWhere(['like', 'no_register', $params['Was1Search']['cari']])
        //     ->orFilterWhere(['like', 'uraian', $params['Was1Search']['cari']])
        //     ->orFilterWhere(['like', 'buril', $params['Was1Search']['cari']])
        //     ->orFilterWhere(['like', 'analisa', $params['Was1Search']['cari']])
        //     ->orFilterWhere(['like', 'kesimpulan', $params['Was1Search']['cari']])
        //     ->orFilterWhere(['like', 'ttd_peg_nik', $params['Was1Search']['cari']])
        //     ->orFilterWhere(['like', 'upload_file', $params['Was1Search']['cari']])
        //     ->orFilterWhere(['like', 'created_ip', $params['Was1Search']['cari']])
        //     ->orFilterWhere(['like', 'updated_ip', $params['Was1Search']['cari']])
        //     ->orFilterWhere(['like', 'ttd_id_jabatan', $params['Was1Search']['cari']]);

		
		$query->andFilterWhere(['like', 'was1_dari',$params['Was1Search']['cari']])
            ->orFilterWhere(['like', 'was1_kepada', $params['Was1Search']['cari']])
			 ->orFilterWhere(['like', 'no_surat', $params['Was1Search']['cari']])
            //->orFilterWhere(['like', 'was1_tgl_surat', $params['Was1Search']['cari']])
            ->orFilterWhere(['like', 'id_level_was1', $params['Was1Search']['cari']]);
        return $dataProvider;
    }
    
	
    public function searchriksa($params)
    {
        $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
        $query="select*from(SELECT DISTINCT
                        A .no_register,
                        A .id_wilayah,
                        A .id_tingkat,
                        A .id_kejati,
                        A .id_kejari,
                        A .id_cabjari,
                        A .perihal_lapdu,
                        A .created_time,
                        b.id_inspektur,
                        c.tanggal_disposisi,
                        (SELECT
                                        string_agg(x.nama_pelapor,',')
                                   FROM was.pelapor x
                                  WHERE x.no_register=A.no_register) nama_pelapor,
                        (SELECT
                                    string_agg(CASE
                                        WHEN x.id_sumber_laporan::text = '11'::text THEN ('LSM '::text || x.sumber_lainnya::text)::character varying
                                        WHEN x.id_sumber_laporan::text = '13'::text THEN ('Sumber lainnya '::text || x.sumber_lainnya::text)::character varying
                                        ELSE y.akronim
                                    END ,',') as sumber_pelapor
                               FROM was.pelapor x
                                 JOIN was.sumber_laporan y ON x.id_sumber_laporan::text = y.id_sumber_laporan::text
                               WHERE x.no_register=A.no_register) sumber_laporan

                FROM
                        was.lapdu A
                INNER JOIN was.terlapor_awal b ON A .no_register = b.no_register and A.id_kejati=b.id_kejati and A.id_kejari=b.id_kejari and A.id_cabjari=b.id_cabjari 
                LEFT JOIN was.was_disposisi_irmud c on b.no_register=c.no_register and A.id_kejati=b.id_kejati and A.id_kejari=b.id_kejari and A.id_cabjari=b.id_cabjari and b.no_urut=c.urut_terlapor)tbl_lapdu
                WHERE
                        tbl_lapdu.id_inspektur = '".$var[0]."'
                        AND tbl_lapdu.tanggal_disposisi IS NOT NULL";
        // /and unitkerja_alias='".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."'"

        $keyWord  = htmlspecialchars($_GET['Was1Search']['cari'], ENT_QUOTES);
         if($_GET['Was1Search']['cari']!=''){
          $query .="  and (upper(tbl_lapdu.no_register) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(tbl_lapdu.perihal_lapdu) ='".($keyWord)."'";
          $query .=" or  upper(tbl_lapdu.nama_pelapor) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(tbl_lapdu.sumber_laporan) like'%".strtoupper($keyWord)."%')";
         }
         $query .=" 
                ORDER BY
                        tbl_lapdu.created_time DESC";


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


	public function searchirmud($params)
    {
       $var=str_split($_SESSION['is_inspektur_irmud_riksa']);


       if($var[1]=='1'){
        $cek_irmud="irmud_pegasum_kepbang";
        }else if($var[1]=='2'){
        $cek_irmud="irmud_pidum_datun";
        }else if($var[1]=='3'){
        $cek_irmud="irmud_intel_pidsus";
        }
        
        if($var[2]=='1'){
        $cek_riksa="status1";
        }else if($var[2]=='2'){
        $cek_riksa="status2";
        }else if($var[2]=='3'){
        $cek_riksa="status1";
        }else if($var[2]=='4'){
        $cek_riksa="status2";
        }else if($var[2]=='5'){
        $cek_riksa="status1";
        }else if($var[2]=='6'){
        $cek_riksa="status2";
        }
        $query = WasRiksaindex::find(['id_inspektur'=>$var[0],'id_irmud'=>$var[1]])->orderBy('created_time desc');
//         
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // $query->andFilterWhere([
        //     'tanggal_surat_terima' => $this->tanggal_surat_terima,
        //     'tanggal_surat_lapdu' => $this->tanggal_surat_lapdu,
        // ]);

        $query->andFilterWhere(['like', 'upper(no_register)',strtoupper($params['Was1Search']['cari'])])
            ->orFilterWhere(['like', 'upper(nama_terlapor_awal)',strtoupper( $params['Was1Search']['cari'])])
            ->orFilterWhere(['like', 'upper(perihal_lapdu)',strtoupper( $params['Was1Search']['cari'])])
            ->orFilterWhere(['like', 'upper(nama_pelapor)',strtoupper( $params['Was1Search']['cari'])])
            ->orFilterWhere(['like', 'upper(sumber_laporan)',strtoupper( $params['Was1Search']['cari'])])
            ->orFilterWhere(['like', 'upper(satker_terlapor_awal)',strtoupper( $params['Was1Search']['cari'])])
            ->orFilterWhere(['like', 'status1', strtoupper( $params['Was1Search']['cari'])])
            ->andFilterWhere(['=', 'id_inspektur', $var[0]])
            ->andFilterWhere(['=', 'id_irmud', $var[1]]);
            // // ->andFilterWhere(['=', $cek_riksa, '1'])
            // ->andFilterWhere(['=', 'b.id_inspektur', $var[0]])
            // ->andFilterWhere(['not',['a.tgl_irmud'=> null]]);
            // ->andFilterWhere(['like', 'inst_satkerkd', $this->inst_satkerkd]);

        return $dataProvider;
    }
	
	
	
    public function searchPelapor($noRegister)
    {
         $query = new Query;
        $query->select('b.nama, b.alamat')
                ->from('was.Lapdu a')
                ->innerJoin('was.pelapor b on (a.no_register=b.no_register)')
                ->where('a.no_register = :noRegister')
                ->addParams([':noRegister' => $noRegister]);
               // ->all;

      
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        

      
        return $dataProvider;
    }
    
     public function searchTerlapor($idRegister)
    {
         $query = new Query;
 


      /*  $query->select('a.peg_nama, a.peg_nip_baru, a.jabatan')
                ->from('kepegawaian.kp_pegawai b')
                ->innerJoin('kepegawaian.kp_h_jabatan c 
on(b .peg_nik = c.peg_nik)')
                 ->innerJoin('kepegawaian.kp_inst_satker d on(
   c.jabat_instunitkerja = d .inst_satkerkd)')
                 ->innerJoin('kepegawaian.kp_unit_kerja e on(
   c.jabat_unitkerja = e.unitkerja_kd)')
                 ->innerJoin('kepegawaian.kp_r_jabatan f on(
   c.ref_jabatan_kd = f.ref_jabatan_kd)')
                 ->innerJoin(' was.terlapor a on (c.id = a.id_h_jabatan)')
                 ->where('a .peg_nik = :pegNik')
                 ->addParams([':pegNik' => '230009754'])
                 ->orderBy('b.peg_nik');
               // ->all;*/
        $query->select('a.peg_nama, a.peg_nip_baru, a.jabatan,b.ba_was_3')
                ->from('was.v_riwayat_jabatan a')
                ->innerJoin('was.terlapor b on (a.id=b.id_h_jabatan)')
                ->where('b.no_register = :idRegister')
                ->addParams([':idRegister' => $idRegister]);
              //  ->orderBy('b.peg_nik');
               // ->all;

      
        

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        

      
        return $dataProvider;
    }
    
     public function searchSatker($idRegister)
    {
        $query = Was1::find()
                ->select('a.inst_satkerkd,b.inst_nama')
                ->from('was.dugaan_pelanggaran a')
                ->innerJoin('kepegawaian.kp_inst_satker b on (a.inst_satkerkd = b.inst_satkerkd)')
                ->where("length(a.inst_satkerkd)= 2 ")
                ->andWhere("a.no_register= :idRegister",[':idRegister' => $idRegister ])
                ->andWhere("b.is_active='1'")
                ->asArray()
                ->one();

        return  $query;
        

     
        }
        
          public function searchRegister($idRegister)
    {
        $no_register = \app\modules\pengawasan\models\Lapdu::findOne(['no_register'=>$idRegister]); 

        return  $no_register;
        

     
        }

 public function searchPenandatanganRiksa($params)
    {
        //strlen('1.6.10.2')
        $gab = $_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2'].'.'.$_SESSION['was_id_level3'];
        if(strlen($gab)=='7'){
            $unit= "and substring(a.unitkerja_kd,1,7)='".$gab."'";
        }else{
            $unit= "and substring(a.unitkerja_kd,1,8)='".$gab."'";
        }
        $query="select * from was.v_penandatangan a inner join was.penandatangan b
                on a.nip=b.nip
                where a.id_surat='was1' $unit 
                and b.kode_level='28'";
        // /and unitkerja_alias='".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."'"
        $keyWord  = htmlspecialchars($_GET['cari_penandatangan'], ENT_QUOTES);
         if($_GET['cari_penandatangan']!=''){
          $query .=" and  (upper(a.nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(a.nip) ='".($keyWord)."'";
          $query .=" or  upper(a.nama_jabatan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(a.jabtan_asli) like'%".strtoupper($keyWord)."%')";
         }


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


    public function searchPenandatanganIrmud($params)
    {
        //strlen('1.6.10.2')
        $gab = $_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2'];
        if(strlen($gab)=='5'){
            $unit= "and substring(a.unitkerja_kd,1,5)='".$gab."'";
        }else{
            $unit= "and substring(a.unitkerja_kd,1,6)='".$gab."'";
        }
        $query="select * from was.v_penandatangan a inner join was.penandatangan b
                on a.nip=b.nip
                where a.id_surat='was1' $unit 
                and b.kode_level='44'";
        // /and unitkerja_alias='".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."'"
        $keyWord  = htmlspecialchars($_GET['cari_penandatangan'], ENT_QUOTES);
         if($_GET['cari_penandatangan']!=''){
          $query .=" and  (upper(a.nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(a.nip) ='".($keyWord)."'";
          $query .=" or  upper(a.nama_jabatan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(a.jabtan_asli) like'%".strtoupper($keyWord)."%')";
         }


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

      public function searchPenandatanganInspektur($params)
    {

        $query="select * from was.v_penandatangan a inner join was.penandatangan b
                on a.nip=b.nip
                where a.id_surat='was1'
                and b.kode_level='7'";
        // /and unitkerja_alias='".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."'"
        $keyWord  = htmlspecialchars($_GET['cari_penandatangan'], ENT_QUOTES);
         if($_GET['cari_penandatangan']!=''){
          $query .=" and  (upper(a.nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(a.nip) ='".($keyWord)."'";
          $query .=" or  upper(a.nama_jabatan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(a.jabtan_asli) like'%".strtoupper($keyWord)."%')";
         }


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
