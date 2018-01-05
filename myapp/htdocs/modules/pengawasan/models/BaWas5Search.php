<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\BaWas5;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;


/**
 * BaWas5Search represents the model behind the search form about `app\modules\pengawasan\models\BaWas5`.
 */
class BaWas5Search extends BaWas5
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ba_was_5', 'no_register', 'tgl_ba_was_5', 'tempat', 'id_terlapor', 'upload_file', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
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
                $query="select*from was.ba_was_5 where no_register='".$_SESSION['was_register']."' 
                and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' 
                and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' 
                and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' 
                and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' 
                and id_level4='".$_SESSION['was_id_level4']."'";
        // $keyWord  = htmlspecialchars($_GET['SpWas2Search']['cari'], ENT_QUOTES);
        //  if($_GET['SpWas2Search']['cari']!=''){
        //   $query .=" and upper(terlapor) like'%".strtoupper($keyWord)."%'";
        //   //$query .=" or  upper(no_register) like'%".strtoupper($keyWord)."%'";
        //   //$query .=" or  upper(pelapor) like'%".strtoupper($keyWord)."%'";
        //  }


        // add conditions that should always apply here

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

     public function searchTerlapor($params)
    {
        $query="select*from(
          select no_register,id_tingkat,id_kejati,id_kejari,id_cabjari,id_wilayah,id_level1,id_level2,id_level3,id_level4,nip_pegawai_terlapor,nama_pegawai_terlapor,golongan_pegawai_terlapor,pangkat_pegawai_terlapor,jabatan_pegawai_terlapor,satker_pegawai_terlapor,'SK-WAS4-D' as sk,no_sk_was_4d as no_sk,tgl_sk_was_4d as tgl_sk,id_sp_was2,id_ba_was2,id_l_was2,id_was15 from was.sk_was_4d where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'
          union 
          select no_register,id_tingkat,id_kejati,id_kejari,id_cabjari,id_wilayah,id_level1,id_level2,id_level3,id_level4,nip_pegawai_terlapor,nama_pegawai_terlapor,golongan_pegawai_terlapor,pangkat_pegawai_terlapor,jabatan_pegawai_terlapor,satker_pegawai_terlapor,'SK-WAS4-E' as sk,no_sk_was_4e as no_sk,tgl_sk_was_4e as tgl_sk,id_sp_was2,id_ba_was2,id_l_was2,id_was15 from was.sk_was_4e where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'
          union
          select no_register,id_tingkat,id_kejati,id_kejari,id_cabjari,id_wilayah,id_level1,id_level2,id_level3,id_level4,nip_pegawai_terlapor,nama_pegawai_terlapor,golongan_pegawai_terlapor,pangkat_pegawai_terlapor,jabatan_pegawai_terlapor,satker_pegawai_terlapor,'SK-WAS4-C' as sk,no_sk_was_4c as no_sk,tgl_sk_was_4c as tgl_sk,id_sp_was2,id_ba_was2,id_l_was2,id_was15 from was.sk_was_4c where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'
          union 
          select no_register,id_tingkat,id_kejati,id_kejari,id_cabjari,id_wilayah,id_level1,id_level2,id_level3,id_level4,nip_pegawai_terlapor,nama_pegawai_terlapor,golongan_pegawai_terlapor,pangkat_pegawai_terlapor,jabatan_pegawai_terlapor,satker_pegawai_terlapor,'SK-WAS4-B' as sk,no_sk_was_4b as no_sk,tgl_sk_was_4b as tgl_sk,id_sp_was2,id_ba_was2,id_l_was2,id_was15 from was.sk_was_4b where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'
          union 
          select no_register,id_tingkat,id_kejati,id_kejari,id_cabjari,id_wilayah,id_level1,id_level2,id_level3,id_level4,nip_pegawai_terlapor,nama_pegawai_terlapor,golongan_pegawai_terlapor,pangkat_pegawai_terlapor,jabatan_pegawai_terlapor,satker_pegawai_terlapor,'SK-WAS4-A' as sk,no_sk_was_4a as no_sk,tgl_sk_was_4a as tgl_sk,id_sp_was2,id_ba_was2,id_l_was2,id_was15 from was.sk_was_4a where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'
          union
          select no_register,id_tingkat,id_kejati,id_kejari,id_cabjari,id_wilayah,id_level1,id_level2,id_level3,id_level4,nip_pegawai_terlapor,nama_pegawai_terlapor,golongan_pegawai_terlapor,pangkat_pegawai_terlapor,jabatan_pegawai_terlapor,satker_pegawai_terlapor,'SK-WAS3-A' as sk,no_sk_was_3a as no_sk,tgl_sk_was_3a as tgl_sk,id_sp_was2,id_ba_was2,id_l_was2,id_was15 from was.sk_was_3a where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'
          union
          select no_register,id_tingkat,id_kejati,id_kejari,id_cabjari,id_wilayah,id_level1,id_level2,id_level3,id_level4,nip_pegawai_terlapor,nama_pegawai_terlapor,golongan_pegawai_terlapor,pangkat_pegawai_terlapor,jabatan_pegawai_terlapor,satker_pegawai_terlapor,'SK-WAS3-B' as sk,no_sk_was_3b as no_sk,tgl_sk_was_3b as tgl_sk,id_sp_was2,id_ba_was2,id_l_was2,id_was15 from was.sk_was_3b where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'
          union 
          select no_register,id_tingkat,id_kejati,id_kejari,id_cabjari,id_wilayah,id_level1,id_level2,id_level3,id_level4,nip_pegawai_terlapor,nama_pegawai_terlapor,golongan_pegawai_terlapor,pangkat_pegawai_terlapor,jabatan_pegawai_terlapor,satker_pegawai_terlapor,'SK-WAS3-C' as sk,no_sk_was_3c as no_sk,tgl_sk_was_3c as tgl_sk,id_sp_was2,id_ba_was2,id_l_was2,id_was15 from was.sk_was_3c where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'
          union
          select no_register,id_tingkat,id_kejati,id_kejari,id_cabjari,id_wilayah,id_level1,id_level2,id_level3,id_level4,nip_pegawai_terlapor,nama_pegawai_terlapor,golongan_pegawai_terlapor,pangkat_pegawai_terlapor,jabatan_pegawai_terlapor,satker_pegawai_terlapor,'SK-WAS2-A' as sk,no_sk_was_2a as no_sk,tgl_sk_was_2a as tgl_sk,id_sp_was2,id_ba_was2,id_l_was2,id_was15 from was.sk_was_2a where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'
          union
          select no_register,id_tingkat,id_kejati,id_kejari,id_cabjari,id_wilayah,id_level1,id_level2,id_level3,id_level4,nip_pegawai_terlapor,nama_pegawai_terlapor,golongan_pegawai_terlapor,pangkat_pegawai_terlapor,jabatan_pegawai_terlapor,satker_pegawai_terlapor,'SK-WAS2-B' as sk,no_sk_was_2b as no_sk,tgl_sk_was_2b as tgl_sk,id_sp_was2,id_ba_was2,id_l_was2,id_was15 from was.sk_was_2b where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'
          union
          select no_register,id_tingkat,id_kejati,id_kejari,id_cabjari,id_wilayah,id_level1,id_level2,id_level3,id_level4,nip_pegawai_terlapor,nama_pegawai_terlapor,golongan_pegawai_terlapor,pangkat_pegawai_terlapor,jabatan_pegawai_terlapor,satker_pegawai_terlapor,'SK-WAS2-C' as sk,no_sk_was_2c as no_sk,tgl_sk_was_2c as tgl_sk,id_sp_was2,id_ba_was2,id_l_was2,id_was15 from was.sk_was_2c where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."') a";





        $keyWord  = htmlspecialchars($_GET['cari_terlapor'], ENT_QUOTES);
         if($_GET['cari_terlapor']!=''){
          $query .=" where (upper(a.nip_pegawai_terlapor) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(a.nama_pegawai_terlapor) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(a.jabatan_pegawai_terlapor) like'%".strtoupper($keyWord)."%')";
         }


        // add conditions that should always apply here

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

    public function searchPenyampai($params)
    {
        $query="select*from was.penandatangan where unitkerja_kd in('1.6','1.6.1','".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."','".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2'].'.'.$_SESSION['was_id_level3']."')";
          // and unitkerja_alias='".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."'";
        $keyWord  = htmlspecialchars($_GET['cari_penandatangan'], ENT_QUOTES);
        // $keyWord2  = htmlspecialchars($_GET['jns_penandatangan'], ENT_QUOTES);
         // if($_GET['jns_penandatangan']!=''){
         // }
         if($_GET['cari_penandatangan']!=''){
          $query .=" and  (upper(jabatan_penandatangan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(nama_penandatangan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(jabatan_penandatangan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  nip ='".$keyWord."')";
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

    public function searchSaksi($params)
    {
        $query="select*from kepegawaian.kp_pegawai ";
        // where unitkerja_kd in('1.6','1.6.1','".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."','".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2'].'.'.$_SESSION['was_id_level3']."')";
        //    and unitkerja_alias='".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."'";
        $keyWord  = htmlspecialchars($_GET['cari_penandatangan'], ENT_QUOTES);
        // $keyWord2  = htmlspecialchars($_GET['jns_penandatangan'], ENT_QUOTES);
         // if($_GET['jns_penandatangan']!=''){
         // }
         if($_GET['cari_penandatangan']!=''){
          $query .=" and  (upper(jabatan_penandatangan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(nama_penandatangan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(jabatan_penandatangan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  nip ='".$keyWord."')";
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
