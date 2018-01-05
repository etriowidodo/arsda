<?php
namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was9;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;

/**
 * Was9Search represents the model behind the search form about `app\models\Was9`.
 */
class Was9_TuSearch extends Was9
{
    /**
     * @inheritdoc
     */
    public function rules()
    {

         return [
            [['id_surat_was9', 'tanggal_was9', 'perihal_was9', 'lampiran_was9', 'no_register', 
              'jenis_saksi', 'hari_pemeriksaan_was9', 'tanggal_pemeriksaan_was9', 'jam_pemeriksaan_was9',
              'tempat_pemeriksaan_was9', 'nip_penandatangan', 'nama_penandatangan', 'pangkat_penandatangan',
              'golongan_penandatangan', 'jabatan_penandatangan', 'was9_file', 'id_sp_was','nomor_surat_was9',
              'sifat_was9'], 'safe'],
        ];

        // return [
        //     [['tanggal_was9','tanggal_pemeriksaan_was9','jam_pemeriksaan_was9','created_time','updated_time',
        //       'sifat_was9','id_pemeriksa','id_sp_was2','id_surat_was9','id_saksi_internal','id_saksi_eksternal',
        //       'trx_akhir','created_by','updated_by','updated_ip','created_ip','nomor_sp_was','perihal_was9','lampiran_was9',
        //       'golongan_pemeriksa','nrp_pemeriksa','nomor_surat_was9','jabatan_pemeriksa','nip_penandatangan','nip_pemeriksa',
        //       'jenis_saksi','hari_pemeriksaan_was9','nama_penandatangan','nama_pemeriksa','di_was9','pangkat_penandatangan','was9_file',
        //       'pangkat_pemeriksa','golongan_penandatangan','jabatan_penandatangan','jbtn_penandatangan','id_tingkat',
        //       'id_kejari','id_kejati','id_cabjari','id_wilayah','id_level1','id_level2','id_level3','id_level4','no_register'], 'safe'],
        // ];
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
    public function search()
    {
       // print_r($jns_saksi);
        $query="select * from was.Was9 where jenis_saksi='".$jns_saksi."' 
                and no_register='".$_SESSION['was_register']."'  
                and id_tingkat='".$_SESSION['kode_tk']."' 
                and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                and id_cabjari='".$_SESSION['kode_cabjari']."' ";
        // print_r($query);
        // exit();

        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          // $query .=" where upper(nama) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(jabatan) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(instansi) like'%".strtoupper($keyWord)."%'";
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

    public function searchSaksiInt_ins($jns_saksi,$id_saksi)
    {
        $query="select a.*,b.* from was.was9 a
                inner join was.saksi_internal b
                on a.id_tingkat = b.id_tingkat and
                a.id_kejati = b.id_kejati and
                a.id_kejari = b.id_kejari and
                a.id_cabjari = b.id_cabjari and
                a.id_saksi_internal = b.id_saksi_internal and
                a.id_wilayah = b.id_wilayah and
                a.id_level1 = b.id_level1 and
                a.id_level2 = b.id_level2 and
                a.id_level3 = b.id_level3 and
                a.id_level4 = b.id_level4 and 
				a.no_register = b.no_register
        where a.jenis_saksi='".$jns_saksi."' and a.no_register='".$_SESSION['was_register']."' 
        and a.id_tingkat='".$_SESSION['kode_tk']."' 
        and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
        and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_saksi_internal=".$id_saksi."
        and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."' 
        and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' 
        and a.id_level4='".$_SESSION['was_id_level4']."'";

        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          // $query .=" where upper(nama) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(jabatan) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(instansi) like'%".strtoupper($keyWord)."%'";
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

    public function searchSaksiEks_ins($jns_saksi,$id_saksi)
    {
        $query="select a.*,b.* from was.was9 a
                inner join was.saksi_eksternal b
                on a.id_tingkat = b.id_tingkat and
                a.id_kejati = b.id_kejati and
                a.id_kejari = b.id_kejari and
                a.id_cabjari = b.id_cabjari and
                a.id_saksi_eksternal = b.id_saksi_eksternal and
                a.id_wilayah = b.id_wilayah and
                a.id_level1 = b.id_level1 and
                a.id_level2 = b.id_level2 and
                a.id_level3 = b.id_level3 and
                a.id_level4 = b.id_level4 and 
				a.no_register = b.no_register
        where a.jenis_saksi='".$jns_saksi."' and a.no_register='".$_SESSION['was_register']."'  
        and a.id_tingkat='".$_SESSION['kode_tk']."' 
        and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
        and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_saksi_eksternal=".$id_saksi."
        and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."' 
        and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' 
        and a.id_level4='".$_SESSION['was_id_level4']."'";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          // $query .=" where upper(nama) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(jabatan) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(instansi) like'%".strtoupper($keyWord)."%'";
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

    public function searchSaksiInternal()
    {
        // if($_SESSION['inspektur']=='1'){
        //   $insp='Inspektur I ';
        // }else if($_SESSION['inspektur']=='2'){
        //   $insp='Inspektur II';
        // }else if($_SESSION['inspektur']=='3'){
        //   $insp='Inspektur III';
        // }else if($_SESSION['inspektur']=='4'){
        //   $insp='Inspektur IV';
        // }else if($_SESSION['inspektur']=='5'){
        //   $insp='Inspektur V';
        // }
      
///////////////// Ambil Session Untuk Kondisi Penandatangan Tu /////////////////////////////////////////////      
        $ses=$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2'].'.'.$_SESSION['was_id_level3'].'.'.$_SESSION['was_id_level4'];
       
       //Kondisi penomoran TU-inspektur
        if($ses=='1.6.1.2.0'){
          $insp='Jaksa Agung Muda PENGAWASAN';
        }else if ('1.6.8.0.0') {
          $insp='Inspektur I';
        }else if ('1.6.9.0.0') {
          $insp='Inspektur II';
        }else if ('1.6.10.0.0') {
          $insp='Inspektur III';
        }else if ('1.6.11.0.0') {
          $insp='Inspektur IV';
        }else if ('1.6.12.0.0') {
          $insp='Inspektur V';
        }

         $query="select a.*,b.* from was.was9 a left join was.saksi_internal b 

				 on a.id_tingkat = b.id_tingkat and
					a.id_kejati = b.id_kejati and
					a.id_kejari = b.id_kejari and
					a.id_cabjari = b.id_cabjari and
					a.id_saksi = b.id_saksi_internal and
					a.id_wilayah = b.id_wilayah and
					a.id_level1 = b.id_level1 and
					a.id_level2 = b.id_level2 and
					a.id_level3 = b.id_level3 and
					a.id_level4 = b.id_level4 and 
					a.no_register = b.no_register
				 where a.no_register='".$_SESSION['was_register']."' 
				 and a.id_tingkat='".$_SESSION['kode_tk']."' 
                 and a.id_kejati='".$_SESSION['kode_kejati']."' 
				 and a.id_kejari='".$_SESSION['kode_kejari']."' 
				 and a.id_cabjari='".$_SESSION['kode_cabjari']."'
         and jenis_saksi='Internal'     
				 and a.id_wilayah='".$_SESSION['id_wil']."' and a.id_level1='".$_SESSION['id_level_1']."' and a.id_level2='".$_SESSION['id_level_2']."'
				 and a.id_level3='".$_SESSION['id_level_3']."' and a.id_level4='".$_SESSION['id_level_4']."' and TRIM(upper(b.jabatan_penandatangan) , ' ')='".strtoupper($insp)."'";      

      //   print_r($query);

        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          // $query .=" where upper(nama) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(jabatan) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(instansi) like'%".strtoupper($keyWord)."%'";
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

        public function searchSaksiEksternal()
    {
      $ses=$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2'].'.'.$_SESSION['was_id_level3'].'.'.$_SESSION['was_id_level4'];
       
       //Kondisi penomoran TU-inspektur
        if($ses=='1.6.1.2.0'){
          $insp='Jaksa Agung Muda PENGAWASAN';
        }else if ('1.6.8.0.0') {
          $insp='Inspektur I ';
        }else if ('1.6.9.0.0') {
          $insp='Inspektur II ';
        }else if ('1.6.10.0.0') {
          $insp='Inspektur III ';
        }else if ('1.6.11.0.0') {
          $insp='Inspektur IV ';
        }else if ('1.6.12.0.0') {
          $insp='Inspektur V ';
        }
        // }else if($_SESSION['inspektur']=='2'){
        //   $insp='Inspektur II';
        // }else if($_SESSION['inspektur']=='3'){
        //   $insp='Inspektur III';
        // }else if($_SESSION['inspektur']=='4'){
        //   $insp='Inspektur IV';
        // }else if($_SESSION['inspektur']=='5'){
        //   $insp='Inspektur V';
        // }'1.6.1.2'
       
        
        $query="select a.*,b.* from was.was9 a left join was.saksi_eksternal b 
                 on a.id_saksi=b.id_saksi_eksternal 
                 and a.no_register=b.no_register
                 and a.id_tingkat=b.id_tingkat
                 and a.id_kejati=b.id_kejati
                 and a.id_kejari=b.id_kejari
                 and a.id_cabjari=b.id_cabjari
                 and a.id_wilayah=b.id_wilayah
                 and a.id_level1=b.id_level1 
                 and a.id_level2=b.id_level2
                 and a.id_level3=b.id_level3
                 and a.id_level4=b.id_level4
                 where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                 and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                 and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_wilayah='".$_SESSION['id_wil']."' 
                 and a.id_level1='".$_SESSION['id_level_1']."' and a.id_level2='".$_SESSION['id_level_2']."' 
                 and a.id_level3='".$_SESSION['id_level_3']."' and a.id_level4='".$_SESSION['id_level_4']."'  
                 and a.id_saksi is not null and jenis_saksi='Eksternal' and upper(a.jabatan_penandatangan)='".strtoupper($insp)."'";
                 //
              //   print_r($query);
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          // $query .=" where upper(nama) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(jabatan) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(instansi) like'%".strtoupper($keyWord)."%'";
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

    public function searchPegawai($params)
    {
        $query="select*from kepegawaian.kp_pegawai";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          $query .=" where upper(nama) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(jabatan) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(instansi) like'%".strtoupper($keyWord)."%'";
         }


        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 8,
      ]
        ]);
        $this->load($params);

        if (!$this->validate()) {

            return $dataProvider;
        }
        
        return $dataProvider;
    }

    public function searchPenandatangan($params)
    {
        $query="select*from was.v_penandatangan where id_surat='was9insp' order by id_jabatan,jabtan_asli";
        $keyWord  = htmlspecialchars($_GET['cari_penandatangan'], ENT_QUOTES);
         if($_GET['cari_penandatangan']!=''){
          $query .=" and  upper(nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(nip) ='".($keyWord)."'";
          $query .=" or  upper(nama_jabatan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(jabtan_asli) like'%".strtoupper($keyWord)."%'";
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
