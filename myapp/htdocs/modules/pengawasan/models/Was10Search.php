<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was10;
use app\modules\pengawasan\components\FungsiComponent; 
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;
/**
 * Was10Search represents the model behind the search form about `app\modules\pengawasan\models\Was10`.
 */
class Was10Search extends Was10
{
    /**
     * @inheritdoc
     */
	public $cari;
    public function rules()
    {
	
        return [
            [['id_tingkat','id_kejati','id_kejari','id_cabjari','no_register', 'was10_tanggal', 'was10_lampiran', 'was10_perihal', 'was10_file','nama_penandatangan', 'pangkat_penandatangan', 'golongan_penandatangan', 'jabatan_penandatangan','created_ip', 'created_time', 'updated_ip', 'updated_time', 'nip_penandatangan','no_surat', 'hari_pemeriksaan_was10', 'tanggal_pemeriksaan_was10', 'jam_pemeriksaan_was10', 'tempat_pemeriksaan_was10', 'nip_pegawai_terlapor', 'nama_pegawai_terlapor', 'pangkat_pegawai_terlapor', 'golongan_pegawai_terlapor', 'jabatan_pegawai_terlapor', 'satker_pegawai_terlapor', 'nip_pemeriksa', 'nama_pemeriksa', 'pangkat_pemeriksa', 'jabatan_pemeriksa', 'golongan_pemeriksa'], 'safe'],
            [['created_by', 'updated_by', 'zona_waktu', 'sifat_surat'], 'integer'],
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
  
  public function searchIndex($params)
    {
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where();
        $query="select*from was.pegawai_terlapor_was10 where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' $where";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          $query .=" and (upper(nama_pegawai_terlapor) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(nip) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(jabatan_pegawai_terlapor) like'%".strtoupper($keyWord)."%')";
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

	public function searchWas10($params)
    {
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where();
        $query="select*from was.was10 where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' $where";
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
	
    public function searchSpwas($params)
    {
        $fungsi   =new FungsiComponent();
        $where    =$fungsi->static_where_alias('a');
        $query="select*from was.pegawai_terlapor a inner join was.sp_was_1 b on a.id_sp_was1=b.id_sp_was1 and a.no_register=b.no_register and a.id_kejari=b.id_kejari and a.id_kejati=b.id_kejati and a.id_cabjari=b.id_cabjari where b.trx_akhir=1  and a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";
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
            'pageSize' => 10,
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
        $query="select*from was.v_penandatangan where id_surat='was10insp' 
                and unitkerja_alias='".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."'";
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


    public function searchWas10Get($no_register,$id_pegawai_terlapor,$nip)
    {
        $fungsi   =new FungsiComponent();
        $where    =$fungsi->static_where();
        $query="select*from was.was10 where no_register='".$no_register."' and id_pegawai_terlapor='".$id_pegawai_terlapor."' and nip_pegawai_terlapor='".$nip."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' $where";
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
}
