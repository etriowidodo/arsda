<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was13Inspeksi;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\Command;

/**
 * Was13Search represents the model behind the search form about `app\modules\pengawasan\models\Was13`.
 */
class Was13InspeksiSearch extends Was13Inspeksi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tanggal_dikirim', 'tanggal_diterima','tanggal_surat','id_was13',
              'id_was12','id_was11','id_was10','id_was9',
              'id_sp_was2','created_by','updated_by','created_ip','updated_ip',
              'created_time','updated_time','nama_pengirim',
              'nama_penerima', 'was13_file','nama_surat','dari','kepada','no_surat_was13',
              'id_tingkat','id_kejati','id_kejari','id_cabjari',
              'id_wilayah','id_level1','id_level2','id_level3','id_level4','no_register'], 'safe'],
            // [['persuratan', 'created_by', 'updated_by'], 'integer'],
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
       $query="select*from was.was13_Inspeksi b
                WHERE  b.id_tingkat::text = '".$_SESSION['kode_tk']."' AND b.id_kejati::text ='".$_SESSION['kode_kejati']."'  
                AND b.id_kejari::text ='".$_SESSION['kode_kejari']."' AND b.id_cabjari::text ='".$_SESSION['kode_cabjari']."'  
                AND b.no_register::text ='".$_SESSION['was_register']."' AND b.id_wilayah::text = '".$_SESSION['was_id_wilayah']."' 
                AND b.id_level1::text ='".$_SESSION['was_id_level1']."'  AND b.id_level2::text ='".$_SESSION['was_id_level2']."' 
                AND b.id_level3::text ='".$_SESSION['was_id_level3']."' AND b.id_level4::text ='".$_SESSION['was_id_level4']."'  ";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          $query .=" and (upper(b.nama_surat) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(b.nama_pengirim) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(b.nama_penerima) like'%".strtoupper($keyWord)."%')";
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

    public function searchIndex_old()
    {
         $query = new Query;
         $query ->select('*')
                ->from('was.Was13Inspeksi')
                ->where(['no_register'=>$_SESSION['was_register'],'is_inspektur_irmud_riksa'=>$_SESSION['is_inspektur_irmud_riksa']]);
        // $query = Was13::find(['no_register'=>$_SESSION['was_register'],'is_inspektur_irmud_riksa'=>$_SESSION['is_inspektur_irmud_riksa']])->orderBy('id_was13');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        

        return $dataProvider;
    }

    public function searchIndex($params)
    {
        $query="select*from was.was13_Inspeksi b
                WHERE  b.id_tingkat::text = '".$_SESSION['kode_tk']."' AND b.id_kejati::text ='".$_SESSION['kode_kejati']."'  
                AND b.id_kejari::text ='".$_SESSION['kode_kejari']."' AND b.id_cabjari::text ='".$_SESSION['kode_cabjari']."'  
                AND b.no_register::text ='".$_SESSION['was_register']."' 
                AND b.id_wilayah::text = '".$_SESSION['was_id_wilayah']."' 
                AND b.id_level1::text ='".$_SESSION['was_id_level1']."'  AND b.id_level2::text ='".$_SESSION['was_id_level2']."' 
                AND b.id_level3::text ='".$_SESSION['was_id_level3']."' AND b.id_level4::text ='".$_SESSION['was_id_level4']."'  ";
        $keyWord  = htmlspecialchars($_GET['Was12Search']['cari'], ENT_QUOTES);
         if($_GET['Was12Search']['cari']!=''){
          $query .=" and upper(b.nama_pegawai_terlapor) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(b.kepada_was12) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(b.di_was12) like'%".strtoupper($keyWord)."%'";
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
	
	public function searchDataWas13($id_register){
        $query = new Query;
        $query ->select('*')
                ->from('was.was_13')
                ->innerjoin('was.v_drop_was13','v_drop_was13.id_surat=was_13.id_surat 
                            and v_drop_was13.persuratan=was_13.persuratan')
                ->where(['was_13.id_register' =>$id_register])
                ->andWhere(['flag'=>'1'])
                ->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            return $dataProvider;
        }
        return $dataProvider;    
    }

    public function searchPenerima(){
        $query="select*from kepegawaian.kp_pegawai ";
        $keyWord  = htmlspecialchars($_GET['cari_penerima'], ENT_QUOTES);
         if($_GET['cari_penerima']!=''){
          $query .=" where (upper(nama) like'%".strtoupper($keyWord)."%')";
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

    public function searchPengirim(){
        $query="select*from kepegawaian.kp_pegawai ";
        $keyWord  = htmlspecialchars($_GET['cari_pengirim'], ENT_QUOTES);
         if($_GET['cari_pengirim']!=''){
          $query .=" where (upper(nama) like'%".strtoupper($keyWord)."%')";
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
