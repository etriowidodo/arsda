<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was16c;
use yii\db\Query;
use yii\data\SqlDataProvider;

/**
 * Was16cSearch represents the model behind the search form about `app\modules\pengawasan\models\Was16c`.
 */
class Was16cSearch extends Was16c
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tingkat', 'id_kejati', 'id_kejari', 'id_cabjari', 'no_register', 'no_was_16c', 'kpd_was_16c', 'di', 'id_terlapor', 'nip_pegawai_terlapor', 'nrp_pegawai_terlapor', 'nama_pegawai_terlapor', 'pangkat_pegawai_terlapor', 'golongan_pegawai_terlapor', 'jabatan_pegawai_terlapor', 'satker_pegawai_terlapor', 'tgl_was_16c', 'tempat', 'lampiran', 'perihal', 'nip_penandatangan', 'nama_penandatangan', 'pangkat_penandatangan', 'golongan_penandatangan', 'jabatan_penandatangan', 'jbtn_penandatangan', 'upload_file', 'created_ip', 'created_time', 'updated_ip', 'updated_time'], 'safe'],
            [['id_sp_was2', 'id_ba_was2', 'id_l_was2', 'id_was15', 'id_was_16c', 'id_wilayah', 'id_level1', 'id_level2', 'id_level3', 'id_level4', 'sifat_surat', 'created_by', 'updated_by'], 'integer'],
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
        $query="select*from was.was_16c where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
        $keyWord  = htmlspecialchars($_GET['Was16cSearch']['cari'], ENT_QUOTES);
        if($_GET['Was16cSearch']['cari']!=''){
          $query .=" and  (upper(no_register) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(nip_pegawai_terlapor) ='".($keyWord)."'";
          $query .=" or  upper(nrp_pegawai_terlapor) ='".($keyWord)."'";
          $query .=" or  upper(nama_pegawai_terlapor) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(perihal) like'%".strtoupper($keyWord)."%')";
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
    public function searchTerlapor(){
        $query="select * from was.ba_was_8 where terima_tolak='2' and no_register='".$_SESSION['was_register']."'  
                and id_tingkat='".$_SESSION['kode_tk']."' 
                and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' 
                and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' 
                and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
        $keyWord  = htmlspecialchars($_GET['cari_terlapor'], ENT_QUOTES);
         if($_GET['cari_terlapor']!=''){
          $query .=" and  (upper(nama_terlapor) like'%".strtoupper($keyWord)."%'";
          $query .=" or nip_terlapor ='".$keyWord."'";
          $query .=" or  upper(jabatan_terlapor) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(pangkat_terlapor) like'%".strtoupper($keyWord)."%')";
          
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

    public function searchPenandatangan(){
        $query="select*from was.v_penandatangan where id_surat='was16c' and unitkerja_alias='".$_SESSION['was_id_wilayah'].'.'.$_SESSION['was_id_level1'].'.'.$_SESSION['was_id_level2']."'";
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
