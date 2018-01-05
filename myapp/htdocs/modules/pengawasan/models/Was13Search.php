<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\Was13;
use yii\data\SqlDataProvider;
use yii\db\Query;
use app\modules\pengawasan\components\FungsiComponent;
use yii\db\Command;

/**
 * Was13Search represents the model behind the search form about `app\modules\pengawasan\models\Was13`.
 */
class Was13Search extends Was13
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'id_was13','id_surat','nama_pengirim','tanggal_dikirim','nama_penerima','tanggal_diterima','was13_file','nama_surat','no_register' ], 'safe'],
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
        $query = Was13::find()->orderBy('id_was13');

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

    // public function searchIndex()
    // {
    //      $query = new Query;
    //      $query ->select('*')
    //             ->from('was.was13')
    //             ->where(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
    //     // $query = Was13::find(['no_register'=>$_SESSION['was_register'],'is_inspektur_irmud_riksa'=>$_SESSION['is_inspektur_irmud_riksa']])->orderBy('id_was13');

    //     $dataProvider = new ActiveDataProvider([
    //         'query' => $query,
    //     ]);

    //     $this->load($params);

    //     if (!$this->validate()) {
    //         // uncomment the following line if you do not want to return any records when validation fails
    //         // $query->where('0=1');
    //         return $dataProvider;
    //     }

        

    //     return $dataProvider;
    // }
    
    public function searchIndex()
    {
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where();
        $query="select *from was.was13 b where b.id_tingkat::text = '".$_SESSION['kode_tk']."' AND b.id_kejati::text ='".$_SESSION['kode_kejati']."'  AND b.id_kejari::text ='".$_SESSION['kode_kejari']."' AND b.id_cabjari::text ='".$_SESSION['kode_cabjari']."'  AND b.no_register::text ='".$_SESSION['was_register']."' $where";
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
	
	public function searchDataWas13($id_register){
        $query = new Query;
        $query ->select('*')
                ->from('was.was_13')
                ->innerjoin('was.v_drop_was13','v_drop_was13.id_surat=was_13.id_surat and v_drop_was13.persuratan=was_13.persuratan')
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
        $query="select*from kepegawaian.kp_pegawai";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
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
        $query="select*from kepegawaian.kp_pegawai";
        $keyWord  = htmlspecialchars($_GET['cari_pengirim'], ENT_QUOTES);
         if($_GET['cari']!=''){
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
