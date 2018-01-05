<?php

namespace app\modules\pengawasan\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use app\modules\pengawasan\models\BaWas4Inspeksi;
use app\modules\pengawasan\components\FungsiComponent;
use yii\db\Query;

/**
 * BaWas2Search represents the model behind the search form about `app\modules\pengawasan\models\BaWas2`.
 */
class BaWas4InspeksiSearch extends BaWas4Inspeksi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_time', 'updated_time', 'tanggal_ba_was_4','tanggal_lahir_saksi_eksternal','no_register','created_ip','updated_ip','nama_saksi_eksternal','file_ba_was_4','tempat_ba_was_4','tempat_lahir_saksi_eksternal','pekerjaan_saksi_eksternal'], 'safe'],
            [['created_by', 'updated_by','id_ba_was4','id_saksi_eksternal','pendidikan_saksi_eksternal','id_wilayah','id_level1','id_level2','id_level3','id_level4','id_agama_saksi_eksternal', 'id_negara_saksi_eksternal'], 'integer'],
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
        // $query = BaWas4Inspeksi::find(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
        //                                'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
        //                                'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
        //                                'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
        //                                'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

        $query="select a.* from was.ba_was_4_inspeksi a
                    where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_wilayah='".$_SESSION['was_id_wilayah']."'
                    and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."'
                    and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."' ";
         
         $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          $query .=" and (upper(nama_saksi_eksternal) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(alamat_saksi_eksternal) like'%".strtoupper($keyWord)."%')";
          // $query .=" or  tanggal_ba_was_4 like'%".strtoupper($keyWord)."%')";
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


    //     $dataProvider = new ActiveDataProvider([
    //         'query' => $query,
    //     ]);

    //     $this->load($params);

    //     if (!$this->validate()) {
    //         // uncomment the following line if you do not want to return any records when validation fails
    //         // $query->where('0=1');
    //         return $dataProvider;
    //     }

    //     $query->andFilterWhere([
    //         'created_by' => $this->created_by,
    //         'created_time' => $this->created_time,
    //         'updated_by' => $this->updated_by,
    //         'updated_time' => $this->updated_time,
    //     ]);

       
    //     return $dataProvider;
    // }

    public function searchSaksiEk(){
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $query="select c.nama as negara_eks,d.nama as agama_eks,e.nama as pendidikan_eks,a.*,b.* 
                from was.was9_inspeksi a  inner join was.saksi_eksternal_inspeksi b 
                on a.no_register = b.no_register and 
                    a.id_tingkat = b.id_tingkat and
                    a.id_kejati  = b.id_kejati and
                    a.id_kejari  = b.id_kejari and
                    a.id_cabjari = b.id_cabjari and
                    a.id_saksi_eksternal = b.id_saksi_eksternal and
                    a.jenis_saksi='Eksternal' and
                    a.id_wilayah=b.id_wilayah and
                    a.id_level1=b.id_level1 and
                    a.id_level2=b.id_level2 and 
                    a.id_level3=b.id_level3 and
                    a.id_level4=b.id_level4
                    inner join public.ms_warganegara c on b.id_negara_saksi_eksternal=c.id
                    inner join public.ms_agama d on b.id_agama_saksi_eksternal=d.id_agama
                    inner join public.ms_pendidikan e on b.pendidikan=e.id_pendidikan
            where a.trx_akhir=1
                    and a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";
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
	
	public function searchSaksiEk_old(){
        $query="select a.*,b.* from was.was9_inspeksi a  inner join was.saksi_eksternal b 
                on a.id_tingkat = b.id_tingkat and
                    a.id_kejati  = b.id_kejati and
                    a.id_kejari  = b.id_kejari and
                    a.id_cabjari = b.id_cabjari and
                    a.id_saksi_eksternal = b.id_saksi_eksternal and
                    a.jenis_saksi='Eksternal' and
                    a.id_wilayah=b.id_wilayah and
                    a.id_level1=b.id_level1 and
                    a.id_level2=b.id_level2 and 
                    a.id_level3=b.id_level3 and
                    a.id_level4=b.id_level4
            where a.trx_akhir=1
                    and a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where ";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         // if($_GET['cari']!=''){
         //  // $query .=" where upper(nama) like'%".strtoupper($keyWord)."%'";
         //  // $query .=" or  upper(jabatan) like'%".strtoupper($keyWord)."%'";
         //  // $query .=" or  upper(instansi) like'%".strtoupper($keyWord)."%'";
         // }


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
