<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was11Inspeksi;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;
/**
 * Was11Search represents the model behind the search form about `app\modules\pengawasan\models\Was11`.
 */
class Was11InspeksiSearch extends Was11Inspeksi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_ip','updated_ip','tgl_was_11','created_time','updated_time','no_was_11', 'kepada_was11',
               'lampiran_was11','perihal','nama_penandatangan','upload_file','di_was11','nip_penandatangan',
               'pangkat_penandatangan','id_tingkat','id_kejati','id_kejari','id_cabjari','no_register',
               'golongan_penandatangan', 'jabatan_penandatangan','jbtn_penandatangan','cari'], 'safe'],
            [['id_surat_was9','id_sp_was2','created_by','updated_by','sifat_surat','id_surat_was11'
              ,'id_wilayah','id_level1','id_level2','id_level3','id_level4'], 'integer'],
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
    public function searchInt($params)
    {
        $query="select*from was.v_was11_insp_int b
                WHERE  b.id_tingkat::text = '".$_SESSION['kode_tk']."' AND b.id_kejati::text ='".$_SESSION['kode_kejati']."'  
                AND b.id_kejari::text ='".$_SESSION['kode_kejari']."' AND b.id_cabjari::text ='".$_SESSION['kode_cabjari']."'  
                AND b.no_register::text ='".$_SESSION['was_register']."' AND b.id_wilayah::text = '".$_SESSION['was_id_wilayah']."' 
                AND b.id_level1::text ='".$_SESSION['was_id_level1']."'  AND b.id_level2::text ='".$_SESSION['was_id_level2']."' 
                AND b.id_level3::text ='".$_SESSION['was_id_level3']."' AND b.id_level4::text ='".$_SESSION['was_id_level4']."'  ";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          $query .=" and (upper(b.no_register) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(b.nama_saksi) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(b.kepada_was11) like'%".strtoupper($keyWord)."%')";
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
 // $query="select*from was.was11_inspeksi b inner join 
 //                was.was11_inspeksi_saksi_ext a on b.id_surat_was11=a.id_was_11
 //                and a.id_tingkat = b.id_tingkat 
 //                and a.id_kejati = b.id_kejati 
 //                and a.id_kejari = b.id_kejari 
 //                and a.id_cabjari = b.id_cabjari 
 //                and a.id_wilayah = b.id_wilayah 
 //                and a.id_level1 = b.id_level1 
 //                and a.id_level2 = b.id_level2 
 //                and a.id_level3 = b.id_level3 
 //                and a.id_level4 = b.id_level4  
 //                where b.id_tingkat::text = '".$_SESSION['kode_tk']."' AND b.id_kejati::text ='".$_SESSION['kode_kejati']."'  
 //                AND b.id_kejari::text ='".$_SESSION['kode_kejari']."' AND b.id_cabjari::text ='".$_SESSION['kode_cabjari']."' 
 //                AND b.no_register::text ='".$_SESSION['was_register']."'  AND b.id_wilayah::text = '".$_SESSION['was_id_wilayah']."' 
 //                AND b.id_level1::text ='".$_SESSION['was_id_level1']."'  AND b.id_level2::text ='".$_SESSION['was_id_level2']."' 
 //                AND b.id_level3::text ='".$_SESSION['was_id_level3']."' AND b.id_level4::text ='".$_SESSION['was_id_level4']."'  ";

    public function searchEks($params)
    {
         // $query="select*from was.was11_inspeksi b inner join 
         //        was.was11_inspeksi_saksi_ext a on b.id_surat_was11=a.id_was_11
         //        and a.id_tingkat = b.id_tingkat 
         //        and a.id_kejati = b.id_kejati 
         //        and a.id_kejari = b.id_kejari 
         //        and a.id_cabjari = b.id_cabjari 
         //        and a.id_wilayah = b.id_wilayah 
         //        and a.id_level1 = b.id_level1 
         //        and a.id_level2 = b.id_level2 
         //        and a.id_level3 = b.id_level3 
         //        and a.id_level4 = b.id_level4  
         //        where b.id_tingkat::text = '".$_SESSION['kode_tk']."' AND b.id_kejati::text ='".$_SESSION['kode_kejati']."'  
         //        AND b.id_kejari::text ='".$_SESSION['kode_kejari']."' AND b.id_cabjari::text ='".$_SESSION['kode_cabjari']."' 
         //        AND b.no_register::text ='".$_SESSION['was_register']."'  AND b.id_wilayah::text = '".$_SESSION['was_id_wilayah']."' 
         //        AND b.id_level1::text ='".$_SESSION['was_id_level1']."'  AND b.id_level2::text ='".$_SESSION['was_id_level2']."' 
         //        AND b.id_level3::text ='".$_SESSION['was_id_level3']."' AND b.id_level4::text ='".$_SESSION['was_id_level4']."'  ";

        $query="select*from was.v_was11_insp_eks b
                WHERE  b.id_tingkat::text = '".$_SESSION['kode_tk']."' AND b.id_kejati::text ='".$_SESSION['kode_kejati']."'  
                AND b.id_kejari::text ='".$_SESSION['kode_kejari']."' AND b.id_cabjari::text ='".$_SESSION['kode_cabjari']."'  
                AND b.no_register::text ='".$_SESSION['was_register']."' AND b.id_wilayah::text = '".$_SESSION['was_id_wilayah']."' 
                AND b.id_level1::text ='".$_SESSION['was_id_level1']."'  AND b.id_level2::text ='".$_SESSION['was_id_level2']."' 
                AND b.id_level3::text ='".$_SESSION['was_id_level3']."' AND b.id_level4::text ='".$_SESSION['was_id_level4']."' ";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          $query .=" and (upper(b.no_register) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(b.nama_saksi) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(b.kepada_was11) like'%".strtoupper($keyWord)."%')";
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

    public function searchsaksi_int($params)
    {
		$query="select *from was.saksi_internal_inspeksi b left join was.was9_inspeksi a
                on a.id_saksi_internal=b.id_saksi_internal
                and a.id_tingkat=b.id_tingkat
                and a.id_kejati=b.id_kejati
                AND a.id_kejari = b.id_kejari
                AND a.id_cabjari = b.id_cabjari
                AND a.no_register = b.no_register
                AND a.id_wilayah = b.id_wilayah 
                AND a.id_level1 = b.id_level1 
                AND a.id_level2 = b.id_level2 
                AND a.id_level3 = b.id_level3 
                AND a.id_level4 = b.id_level4 
            where b.id_tingkat::text = '".$_SESSION['kode_tk']."' AND b.id_kejati::text ='".$_SESSION['kode_kejati']."'  
            AND b.id_kejari::text ='".$_SESSION['kode_kejari']."' AND b.id_cabjari::text ='".$_SESSION['kode_cabjari']."' 
            AND b.no_register::text ='".$_SESSION['was_register']."'  AND b.id_wilayah::text = '".$_SESSION['was_id_wilayah']."' 
            AND b.id_level1::text ='".$_SESSION['was_id_level1']."'  AND b.id_level2::text ='".$_SESSION['was_id_level2']."' 
            AND b.id_level3::text ='".$_SESSION['was_id_level3']."' AND b.id_level4::text ='".$_SESSION['was_id_level4']."' 
            and a.trx_akhir='1' and a.jenis_saksi='Internal'";
        $keyWord  = htmlspecialchars($_GET['was11Inspeksi']['cari'], ENT_QUOTES);
         if($_GET['was11Inspeksi']['cari']!=''){
          // $query .=" and upper(b.nama_pegawai_terlapor) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(b.kepada_was12) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(b.di_was12) like'%".strtoupper($keyWord)."%'";
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

    public function searchsaksi_eks($params)
    {
    $query="select *from was.saksi_eksternal_inspeksi b inner join was.was9_inspeksi a 
                on a.id_saksi_eksternal=b.id_saksi_eksternal
                and a.id_tingkat=b.id_tingkat
                and a.id_kejati=b.id_kejati
                AND a.id_kejari = b.id_kejari
                AND a.id_cabjari = b.id_cabjari
                AND a.no_register = b.no_register
                AND a.id_wilayah = b.id_wilayah 
                AND a.id_level1 = b.id_level1 
                AND a.id_level2 = b.id_level2 
                AND a.id_level3 = b.id_level3 
                AND a.id_level4 = b.id_level4 
            where b.id_tingkat::text = '".$_SESSION['kode_tk']."' AND b.id_kejati::text ='".$_SESSION['kode_kejati']."'  
            AND b.id_kejari::text ='".$_SESSION['kode_kejari']."' AND b.id_cabjari::text ='".$_SESSION['kode_cabjari']."'  
            AND b.no_register::text ='".$_SESSION['was_register']."'  AND b.id_wilayah::text = '".$_SESSION['was_id_wilayah']."' 
            AND b.id_level1::text ='".$_SESSION['was_id_level1']."'  AND b.id_level2::text ='".$_SESSION['was_id_level2']."' 
            AND b.id_level3::text ='".$_SESSION['was_id_level3']."' AND b.id_level4::text ='".$_SESSION['was_id_level4']."'
            and a.trx_akhir='1' and a.jenis_saksi='Eksternal'
            ";
        $keyWord  = htmlspecialchars($_GET['was11Inspeksi']['cari'], ENT_QUOTES);
         if($_GET['was11Inspeksi']['cari']!=''){
          // $query .=" and upper(b.nama_pegawai_terlapor) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(b.kepada_was12) like'%".strtoupper($keyWord)."%'";
          // $query .=" or  upper(b.di_was12) like'%".strtoupper($keyWord)."%'";
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
        $query="select*from was.v_penandatangan where id_surat='was11insp' and unitkerja_alias='".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."'";
        $keyWord  = htmlspecialchars($_GET['cari_penandatangan'], ENT_QUOTES);
         if($_GET['cari_penandatangan']!=''){
          $query .=" and  (upper(nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(nip) ='".($keyWord)."'";
          $query .=" or  upper(nama_jabatan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(jabtan_asli) like'%".strtoupper($keyWord)."%')";
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
