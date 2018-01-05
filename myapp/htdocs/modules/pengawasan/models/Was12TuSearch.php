<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was12;
use app\modules\pengawasan\models\Was10;
use app\modules\pengawasan\components\FungsiComponent;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;

/**
 * Was12Search represents the model behind the search form about `app\modules\pengawasan\models\Was12`.
 */
class Was12TuSearch extends Was12
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_was_12', 'tanggal_was12', 'perihal_was12', 'lampiran_was12', 'kepada_was12', 'di_was12', 'nip_penandatangan', 'nama_penandatangan', 'pangkat_penandatangan', 'golongan_penandatangan', 'jabatan_penandatangan', 'was12_file', 'jbtn_penandatangan', 'no_surat'], 'safe'],
            [['sifat_surat'], 'integer'],
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
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where();

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

        $query="select *from was.v_was12 b where b.id_tingkat::text = '".$_SESSION['kode_tk']."' 
                AND b.id_kejati::text ='".$_SESSION['kode_kejati']."'  
                AND b.id_kejari::text ='".$_SESSION['kode_kejari']."' 
                AND b.id_cabjari::text ='".$_SESSION['kode_cabjari']."'  
                AND b.no_register::text ='".$_SESSION['was_register']."' 
                AND TRIM(upper(b.jabatan_penandatangan) , ' ')='".strtoupper($insp)."'";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          $query .=" and (upper(b.no_surat) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(b.kepada_was12) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(b.di_was12) like'%".strtoupper($keyWord)."%')";
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
  
  
       public function searchTerlapor($params)
    {
  
        $query = Was10::findBySql("select max(created_time) as created_time, nip_pegawai_terlapor,nama_pegawai_terlapor,jabatan_pegawai_terlapor,
pangkat_pegawai_terlapor,golongan_pegawai_terlapor,satker_pegawai_terlapor from was.was10 where no_register= :id group by nip_pegawai_terlapor,nama_pegawai_terlapor,jabatan_pegawai_terlapor, pangkat_pegawai_terlapor,golongan_pegawai_terlapor,satker_pegawai_terlapor
", [':id' => $_SESSION['was_register'] ] );
 
         /*       VRiwayatJabatan::find()->from('was.v_riwayat_jabatan a')->innerJoin('was.pemeriksa b', '(a.id=b.id_h_jabatan) ')->where("id_register = :id",[':id' => $id_register ]);*/
       $dataProvider = new ActiveDataProvider([
            'query' => $query,
      'pagination' => [
      'pageSize' => 10,
      ],
        ]);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        return $dataProvider;
        }
    
  public function searchTerlaporWas10($params)
    {
        $fungsi   =new FungsiComponent();
        $where    =$fungsi->static_where();
        $query    ="select*from was.v_was10 where id_surat_was10 is not null and id_tingkat::text = '".$_SESSION['kode_tk']."' AND id_kejati::text ='".$_SESSION['kode_kejati']."'  AND id_kejari::text ='".$_SESSION['kode_kejari']."' AND id_cabjari::text ='".$_SESSION['kode_cabjari']."'  AND no_register::text ='".$_SESSION['was_register']."' and trx_akhir=1 $where";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          $query .=" and upper(nama_pegawai_terlapor) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(jabatan_pegawai_terlapor) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(nip) like'%".strtoupper($keyWord)."%'";
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
        $query="select*from was.v_penandatangan where id_surat='was12'";
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
